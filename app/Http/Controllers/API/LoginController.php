<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invitation_accepted;
use App\Models\Token;
use App\Models\Apprenant;
use App\Http\Requests\LoginAPIRequest;
use App\Http\Requests\RefreshTokenAPIRequest;
use App\Http\Requests\SignUpAPIRequest;
use App\Http\Requests\EmailLogAPIRequest;

use App\Http\Controllers\AppBaseController;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;

use Carbon\Carbon;

define('DURATION', '3456000');

class LoginController extends AppBaseController
{
    public function login(LoginAPIRequest $request){
        $inputs = $request->all();
       
        $user = User::where('email', $inputs['email'])->first();

        if(!empty($user))
            if(Hash::check($inputs['password'], $user->password)){
                $refresh_token = 'Bearer ' . Str::random(50);
                $access_token = 'Bearer ' . Str::random(50);

                $expired_at = Carbon::now()
                            ->addSeconds(DURATION)
                            ->format('Y-m-d H:i:s');
                $current_date = Carbon::now()
                            ->format('Y-m-d H:i:s');

                DB::table('tokens')
                    ->where('tokens.user_id', $user->id)
                    ->where('expired_at', '<', $current_date )
                    ->update(['token' => $access_token, 'refresh_token' => $refresh_token, 'expired_at' => $expired_at]);
                
                $token = DB::table('tokens')
                    ->select('users.nom', 'users.prenom', 'users.email', 'users.avatar', 'tokens.token', 'tokens.refresh_token')
                    ->join('users', 'users.id', 'tokens.user_id')
                    ->where('tokens.user_id', $user->id)
                    ->first();

                return $this->sendResponse($token,'Successfully connected !');
            }

        return $this->sendError('Credentials filled are incorrect !');
    }

    public function refresh_token(RefreshTokenAPIRequest $request){
        $inputs = $request->all();

        $access_token = 'Bearer ' . Str::random(50);
        $expire_at = Carbon::now()
                    ->addSeconds(DURATION)
                    ->format('Y-m-d H:i:s');
        $current_date = Carbon::now()
                    ->format('Y-m-d H:i:s'); 

        DB::table('tokens')
            ->where('tokens.refresh_token', $inputs['refresh_token'])
            ->where('expired_at', '<', $current_date )
            ->update(['token' => $access_token, 'expired_at' => $expire_at]);

        $token = Token::select('token')->where('refresh_token', $inputs['refresh_token'])->first();

        if(!empty($token))
            return $this->sendResponse($token, 'Access token refresh successfully !');
        else
            return $this->sendError('Refresh token invalid !');
    }

    public function register(SignUpAPIRequest $request){
        $inputs = $request->all();

        $password = bcrypt($inputs["password"]);
        $user = null;
        $user = DB::transaction(function() use ($inputs, $request, $password) {
            $inputs = $request->all();

            //Create the User
            $user = User::create([
                'nom' => $inputs["nom"],
                'prenom' => $inputs["prenom"],
                'email' => $inputs["email"],
                'avatar' => NULL,
                'code_promo_invite' => $inputs["code_promo_invite"],
                'role_id' => 2,
                'address_id' => NULL,
                'password' => $password,
            ]);

            $uni_rand = '000abc';
            $rand = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $uni_rand[rand(0, strlen($uni_rand) - 1)];

            $code_rand = str_shuffle($rand);
            $uni_prenom = substr($user->prenom,0,1);
            $uni_nom = substr($user->nom,0,1);
            $code = $uni_prenom.$uni_nom.$code_rand;

            DB::table('users')->where('id', $user->id)->update(['code_promo' => $code]);
            //Followed by the 'apprenant'
            Apprenant::create([
                'user_id' => $user->id,
                'couleur_id' => NULL,
                'whatsapp' => NULL,
            ]);

        $user_checks = DB::table('users')->where('code_promo', $user->code_promo_invite)->first();
        
        if($user_checks){
            $invite_accepted = new Invitation_accepted;
            $invite_accepted->user_host_id = $user_checks->id;
            $invite_accepted->user_guest_id = $user->id;
            $invite_accepted->save() ;
            //Invitation_accepted::create([
                //'user_host_id' => $user_checks->id,
                //'user_guest_id' => $user->id,
            //]);
        }
            //Create token dedicated to the user
            if(!empty($user)){
                $expired_at = Carbon::now()
                            ->addSeconds(DURATION)
                            ->format('Y-m-d H:i:s');
                $token_id = Str::random(50);
                $refresh_token_id =  Str::random(50);

                $token = Token::create([
                    'tokenable_type' => "\Model\Apprenant",
                    'token' => 'Bearer ' . $token_id,
                    'user_id' => $user->id,
                    'scope' => 'User',
                    'state' => 1,
                    'refresh_token' => 'Bearer ' . $refresh_token_id,
                    'expired_at' => $expired_at,
                ]);
                $user->token = $token->token;
                $user->refresh_token = $token->refresh_token;
            }

            return $user;
        }, 1);

        if(!empty($user))
			return $this->sendResponse($user, 'Successfully registered !');
    
        return $this->sendError('Something went wrong !');
        
    }

    public function logout(Request $request){
		$token = $request->header('Authorization');
        $state = DB::table('tokens')
            ->where('tokens.token', $token)
            ->update(['token' => NULL, 'refresh_token' => NULL,'expired_at' => NULL]);

		if($state)
			return $this->sendSuccess('Disconnection successfully done !');
		else
			return $this->sendError('Error encountered, make sure you are already connected !');
	}

    public function email_log(EmailLogAPIRequest $request){
        $inputs = $request->all();
       
        $user = User::where('email', $inputs['email'])->first();

        if(!empty($user)){
            $refresh_token = 'Bearer ' . Str::random(50);
            $access_token = 'Bearer ' . Str::random(50);

            $expired_at = Carbon::now()
                        ->addSeconds(DURATION)
                        ->format('Y-m-d H:i:s');
            $current_date = Carbon::now()
                        ->format('Y-m-d H:i:s');

            DB::table('tokens')
                ->where('tokens.user_id', $user->id)
                ->where('expired_at', '<', $current_date )
                ->update(['token' => $access_token, 'refresh_token' => $refresh_token, 'expired_at' => $expired_at]);
            
            $token = DB::table('tokens')
                ->select('users.nom', 'users.prenom', 'users.email', 'users.avatar', 'tokens.token', 'tokens.refresh_token')
                ->join('users', 'users.id', 'tokens.user_id')
                ->where('tokens.user_id', $user->id)
                ->first();

            return $this->sendResponse($token,'Successfully connected !');
        }else{
            $raw_password = Str::random(8);
            $password = bcrypt($raw_password);
            $user = null;
            $user = DB::transaction(function() use ($inputs, $request, $password, $raw_password) {
                $inputs = $request->all();
    
                //Create the User
                $user = User::create([
                    'nom' => $inputs["nom"],
                    'prenom' => $inputs["prenom"],
                    'email' => $inputs["email"],
                    'avatar' => NULL,
                    'role_id' => 2,
                    'address_id' => NULL,
                    'password' => $password,
                ]);
                //Followed by the 'apprenant'
                Apprenant::create([
                    'user_id' => $user->id,
                    'couleur_id' => NULL,
                    'telephone' => NULL,
                    'whatsapp' => NULL,
                ]);
    
                //Create token dedicated to the user
                if(!empty($user)){
                    $expired_at = Carbon::now()
                                ->addSeconds(DURATION)
                                ->format('Y-m-d H:i:s');
                    $token_id = Str::random(50);
                    $refresh_token_id =  Str::random(50);
    
                    $token = Token::create([
                        'tokenable_type' => "\Model\Apprenant",
                        'token' => 'Bearer ' . $token_id,
                        'user_id' => $user->id,
                        'scope' => 'User',
                        'state' => 1,
                        'refresh_token' => 'Bearer ' . $refresh_token_id,
                        'expired_at' => $expired_at,
                    ]);
                    $user->raw_password = $raw_password;
                    $user->token = $token->token;
                    $user->refresh_token = $token->refresh_token;
                }
    
                return $user;
            }, 1);
    
            if(!empty($user))
                return $this->sendResponse($user, 'Successfully registered !');
        }

        return $this->sendError('Credentials filled are incorrect !');
    }

    public function see_my_guests()

    {

        $token = $request->header('Authorization');
        $user_token = DB::table('tokens')
        ->select('tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        /** @var User $user */
        $my_invite = User::find($user_token->user_id);
        
        $my_users = DB::table('invitation_accepteds')->where('user_host_id', $my_invite)->get();

        foreach($my_users as $my_user)
        { 
            $my_invitations = DB::table('users')->where('id', $my_user->user_guest_id)->get();
        }
        
        
        return $this->sendResponse($my_invitations->toArray(), 'Successfully');
        
    }
}
