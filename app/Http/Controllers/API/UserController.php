<?php


namespace App\Http\Controllers\API;


use App\Helpers\api\Helpers;
use App\Helpers\UploadableTrait;
use App\Models\Driver;
use App\Models\Passager;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController
{
    use UploadableTrait;
    public function update_profile(Request $request)
    {
        $personnal = $request->personnal;
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            $err = null;
            foreach ($validator->errors()->all() as $error) {
                $err = $error;
            }
            return Helpers::error($err);
        }
        $personnal->first_name=$request->first_name;
        $personnal->last_name=$request->last_name;
        $personnal->phone=$request->phone;
        $personnal->email=$request->email;
        $personnal->save();
        return Helpers::success([],'Mot de passe modifie avec success');
    }
    public function change_password(Request $request)
    { $personnal = $request->personnal;
        $validator = Validator::make($request->all(), [
            'new_password' => 'required',
            'old_password' => 'required',
        ]);
        if ($validator->fails()) {
            $err = null;
            foreach ($validator->errors()->all() as $error) {
                $err = $error;
            }
            return Helpers::error($err);
        }
        if (!Auth::attempt(['phone' => $personnal->phone, 'password' => $request->old_password])) {
            return Helpers::error('Invalid credentials', ['error'=>'Invalid credentials']);
        }
        $personnal->password=bcrypt($request->new_password);
        $personnal->save();
        return Helpers::success([],'Mot de passe modifie avec success');
    }
    public function createUser(Request $request)
    {
        logger($request->all());
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $err = null;
            foreach ($validator->errors()->all() as $error) {
                $err = $error;
            }
            return Helpers::error($err);
        }
        $user = User::query()->firstWhere(['phone' => $request->phone]);
        if (!is_null($user)) {
            return Helpers::error('Duplicate entry' . $request->phone . ' for key phone');
        }
        $body = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'country_id' => $request->country,
            'password' => bcrypt($request->password),
        ];
        try {
            DB::beginTransaction();
            $user = new User($body);
            $user->save($body);
            $passager = new Passager([
                'user_id' => $user->id
            ]);
            $passager->save();
            DB::commit();
            $payload = [
                'iss' => 'cam_and_go_api',
                'sub' => $user->id,
                'iat' => time(),
                'exp' => time() + 3600
            ];
            $privateKey = file_get_contents('private.pem');
            $jwt = JWT::encode($payload, $privateKey, 'RS256');
            return Helpers::success([
                'auth' => [
                    'access_token' => $jwt,
                    'token_type' => 'bearer',
                    'expires_in' => 3600
                ],
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'country_name' => $user->country->name,
                'country_id' => $user->country->id,
                'country_code_phone' => $user->country->code_phone,
                'passager_id' => $passager->id,
                'balance' => $user->balance,
            ]);
        } catch (\Exception $exception) {
            return Helpers::error($exception->getMessage());
        }

    }

    public function authenticate(Request $request)
    {
        $privateKey = file_get_contents('private.pem');
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = User::query()->firstWhere(['phone' => $request->phone]);
            // Génère un JWT signé avec SA clé privée
            $payload = [
                'iss' => 'cam_and_go_api',
                'sub' => $user->id,
                'iat' => time(),
                'exp' => time() + 3600
            ];

            $jwt = JWT::encode($payload, $privateKey, 'RS256');
            return Helpers::success([
                'auth' => [
                    'access_token' => $jwt,
                    'token_type' => 'bearer',
                    'expires_in' => 3600
                ],
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'country_name' => $user->country->name,
                'country_code_phone' => $user->country->code_phone,
                'country_id' => $user->country->id,
                'balance' => $user->balance,
            ]);
        } else {
            return Helpers::error('Invalid credentials', ['error'=>'Invalid credentials']);
        }
    }

    public function uploadPhoto(Request $request)
    {
        $personnal = $request->personnal;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            //$path = $file->store('uploads', 'public');
            $personnal->photo = $this->uploadOne($file, 'photos');
            $personnal->save();
            return Helpers::success($personnal);
        }
        return Helpers::success([]);
    }
}
