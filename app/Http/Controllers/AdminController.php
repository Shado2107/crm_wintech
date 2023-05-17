<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Auth\RegistersUsers;
use DB;  
use Auth;
use Mail; 
use Illuminate\Contracts\Encryption\DecryptException;
use Crypt;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Formateur;
use App\Models\Demande_transaction;
use Socialite;
use Exception;
use Session;
use Flash;
use App\Mail\BienvenueMoveskills;
use App\Mail\InvitationMoveskills;
use App\Mail\InvitationApprenant;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Mail\DemandeFormateur;
use App\Mail\DemandeAdmin;

class AdminController extends Controller
{
    //

     use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    } 
    
     public function demande_transaction()
    {
        $demandes = DB::table('demande_transactions')->get();
        return view('parcourFormation.demande_transaction', compact('demandes'));
    }
    
     public function demande_transactionStore(Request $request)
    {
        $message = "Demande envoyée avec succès";
        $demande = new Demande_transaction;
        $demande->type = $request->type;
        $demande->phone = $request->phone;
        $demande->montant = $request->montant;
        $demande->confirme = $request->confirme;
        $demande->user_id = Auth::user()->id;
        $demande->save();
        
        $admin = "axel.n@illimitis.com";
        \Mail::to($admin)->send(new DemandeAdmin($demande));
        return back()->with(['message' => $message]);
    }
    
     public function demande_transactionUpdate(Request $request, $id)
    {
        $message = "Demande validée avec succès";
        $demande = Demande_transaction::findOrFail($id);
        $demande->etat = $request->etat;
        $demande->save();
        if($demande->etat == 1)
        {
        $user = DB::table('users')->where('id', $demande->user_id)->first();
        \Mail::to($user->email)->send(new DemandeFormateur($user, $demande));
        }
        return back()->with(['message' => $message]);
    }
    
     public function transaction()
    {
        //$intrant_equipements = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/6442c0119f2a9b814db1653287a0866e/feed');
        // $payment = Http::get('https://client.cinetpay.com/v1/auth/login?apikey=1572230280637cafc47a8259.83054450&password=Moveskills@2023');
        // dd($payment);
        
        $curl = curl_init();
        $auth_data = array(
        	'apikey' 		=> '1572230280637cafc47a8259.83054450',
        	'password' 	=> 'Moveskills@2023'
        );
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $auth_data);
        curl_setopt($curl, CURLOPT_URL, 'https://client.cinetpay.com/v1/auth/login');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
         $data = json_decode( $result, true );
        curl_close($curl);
         return $data['data']['token'];
       
   
   // return json_deco($data['data']['token'], true);
    }
    
    
    
        public function transfert_contact(Request $request)
    {
        
            $exoclick_token = $this->transaction();
         // foreach($exoclick_tokens->data as $exoclick_token){
        // $new_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIwNTgyOSwiaXNzIjoiaHR0cHM6Ly9jbGllbnQuY2luZXRwYXkuY29tL3YxL2F1dGgvbG9naW4iLCJpYXQiOjE2NzY1NDAzMjMsImV4cCI6MTY3NjU0NzU4MywibmJmIjoxNjc2NTQwMzIzLCJqdGkiOiIxRVlRR29hR0pVclYyblowIn0.mjGy92WUSS6oI3aFGtL4XmdaQFc4Fec-8b8nC66ndvM";
         $new_token = $exoclick_token;
            
            $auth_array = array(
                    "Authorization:",
                    "Bearer",
                    $new_token
            );
            
            $send_transfert = [
                
                'prefix' => '221',
                    'phone' => '777092285',
                    'name' => 'fallou',
                    'surname' => 'gueye',
                    'email' => 'fallou.g@illimitis.com'
                
                ];
            
            $fields_string = http_build_query($send_transfert);
            $new_token = implode(" ", $auth_array);
            
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://client.cinetpay.com/v1/transfer/contact",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => "",
              CURLOPT_HTTPHEADER => array(
                 $new_token,
                 "Content-Type: application/json",
                 "cache-control: no-cache",
                'prefix' =>  '221',
                'phone' => '777092285',
                'name' => 'fallou',
                'surname' => 'gueye',
                'email' => 'fallou.g@illimitis.com'
                
              ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            $data = json_decode($response, true);
            
            // -> do something with the data
            dd($response);
            
    }
    
        public function get_transaction(Request $request)
    {
        
            $exoclick_token = $this->transaction();
         // foreach($exoclick_tokens->data as $exoclick_token){
        // $new_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIwNTgyOSwiaXNzIjoiaHR0cHM6Ly9jbGllbnQuY2luZXRwYXkuY29tL3YxL2F1dGgvbG9naW4iLCJpYXQiOjE2NzY1NDAzMjMsImV4cCI6MTY3NjU0NzU4MywibmJmIjoxNjc2NTQwMzIzLCJqdGkiOiIxRVlRR29hR0pVclYyblowIn0.mjGy92WUSS6oI3aFGtL4XmdaQFc4Fec-8b8nC66ndvM";
         $new_token = $exoclick_token;
            
            $auth_array = array(
                    "Authorization:",
                    "Bearer",
                    $new_token,
                    'prefix' => '226',
                    'phone' => '777092285',
                    'name' => 'fallou',
                    'surname' => 'gueye',
                    'email' => 'fallou.g@illimitis.com'
            );
            
            $new_token = implode(" ", $auth_array);
            
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://client.cinetpay.com/v1/transfer/contact",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_POSTFIELDS => "",
              CURLOPT_HTTPHEADER => array(
                 $new_token,
                 "Content-Type: application/json",
                 "cache-control: no-cache"
              ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            $data = json_decode($response, true);
            
            // -> do something with the data
            dd($data);
            
    }
    
    /**
     * Redirect the user to the Linkedin authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->scopes(['r_liteprofile', 'r_emailaddress'])->redirect();
    }
    
    /**
     * Obtain the user information from Linkedin.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect('/admin/dashboard');
    }
       
   /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        
        else {
        
        $usss = new User;
        $usss->prenom = $user->name;
        $usss->nom = $user->name;
         $usss->email = $user->email;
          $usss->role_id = 3;
           $usss->provider = $provider;
            $usss->provider_id = $user->id;
             $usss->password = Hash::make(123456);

             if($usss->save()) 
             {
                
        
         Auth::login($authUser, true);
        $us = DB::table('users')->where('email', $usss->email)->first();
        $formateur = new Formateur;
                $formateur->user_id = $usss->id;
                $formateur->save();
                return redirect('/admin/dashboard');
        }
        }
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
       
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        try {
     
            $user = Socialite::driver('google')->user();
       
            $finduser = User::where('google_id', $user->id)->first();
      
            if($finduser){
      
                Auth::login($finduser);
     
                return redirect('/admin/dashboard');
      
            }else{
                $usss = new User;
        $usss->prenom = $user->name;
        $usss->nom = $user->name;
         $usss->email = $user->email;
          $usss->role_id = 3;
            $usss->google_id = $user->id;
             $usss->password = Hash::make(123456);

             if($usss->save()) 
             {
                
        
         Auth::login($usss, true);
        $us = DB::table('users')->where('email', $usss->email)->first();
        $formateur = new Formateur;
                $formateur->user_id = $usss->id;
                $formateur->save();
                return redirect('/admin/dashboard');
             }
              
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }


    public function dashboard()
    {
     
     return view('home');
    }
    
    public function dashboard_admin()
    {
     
     return view('home_admin');
    }

    public function login(Request $request)
    {
      
      if($request->isMethod('post')){
            $admin = "Bienvenue sur l'espace formateur";
            $message = 'Email ou mot de passe incorrect';

            $data = $request->input();
            
            if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'role_id'=> '3'])){

                //echo "succes"; die;
                return redirect('/admin/dashboard')->with(['admin' => $admin]);
            }
            
            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'role_id'=> '1'])){

                //echo "succes"; die;
                return redirect('/dashboard_admin')->with(['admin' => $admin]);
            }
            
            
             elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'role_id'=> '4'])){

                //echo "succes"; die;
                return redirect('/dashboard_cinetpay')->with(['admin' => $admin]);
            }
           
             
            else{
                Flash::error($message);

                return redirect('/connexion')->with(['message' => $message]);  
            }
        }
        return view('login');
    }

    public function connexion()
    {
     
     return view('login');
    }

    public function inscription()
    {
     
     return view('register');
    }

    public function inscription_store(Request $request)
     {
         //
 
         request()->validate([
             'nom' => 'required|string|max:255',
             'prenom' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users',
             'password' => 'required|string|min:6|confirmed',
 
     ]);
 
          $randomString = Str::lower(Str::random(4));
             $message = "Ajouté avec succès";

             $user = new User;
             $user->prenom = $request->get('prenom'); 
             $user->nom = $request->get('nom'); 
             $user->email = $request->get('email'); 
             $user->role_id = 3; 
             $user->code_promo = substr($user->prenom,0,1).substr($user->nom,0,1).$randomString; 
             $user->password = Hash::make($request->get('password'));

             if($user->save()) 
             {
                //  $codepromo = substr($user->prenom,0,1).substr($user->nom,0,1).$randomString;
                //  DB::table('users')->where('id', $user->id)->update(['code_promo' => substr($user->prenom,0,1).substr($user->nom,0,1).$randomString]);
                $formateur = new Formateur;
                $formateur->user_id = $user->id;
                $formateur->save();

                 Auth::login($user);
                  \Mail::to($user->email)->send(new BienvenueMoveskills($user));
                 return redirect('/admin/dashboard')->with(['message' => $message]);
     
             }
             else
             {
                 flash('user not saved')->error();
     
             }
     
     
     return back()->with(['message' => $message]);
 
     }


}
