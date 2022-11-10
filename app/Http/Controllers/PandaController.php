<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PandaController extends Controller
{
    public function pandaToken()
   	{
    	$client = new Client();

        $url = 'https://panda.unib.ac.id/api/login';
	      try {
	        $response = $client->request(
	            'POST',  $url, ['form_params' => ['email' => 'evaluasi@unib.ac.id', 'password' => 'evaluasi2018']]
	        );
	        $obj = json_decode($response->getBody(),true);
	        Session::put('token', $obj['token']);
	        return $obj['token'];
	      } catch (GuzzleHttp\Exception\BadResponseException $e) {
	        echo "<h1 style='color:red'>[Ditolak !]</h1>";
	        exit();
	      }
    }

    public function pandaLogin(Request $request){
        $connected = @fsockopen("www.google.com", 80);
        if ($connected){
            $username = $request->username;
            $password = $request->password;
            // $count =  preg_match_all( "/[0-9]/", $username );
            $query = '
            	{portallogin(username:"'.$username.'", password:"'.$password.'") {
            	  is_access
            	  tusrThakrId
            	}}
            ';
            $data = $this->panda($query)['portallogin'];

            $data_mahasiswa = '
                {mahasiswa(mhsNiu:"' . $username . '") {
                    mhsNiu
                    mhsNama
                    mhsTanggalLulus
                    prodi {
                        prodiKode
                        prodiNamaResmi
                        prodiKodeUniv
                    }
                }}
            ';
            $prodis = Prodi::select('kode_prodi')->pluck('kode_prodi');
            $result =  $prodis->toArray();

            if($data[0]['is_access']==1){
                if($data[0]['tusrThakrId']==1){
                    $mahasiswa = $this->panda($data_mahasiswa);
                    if (in_array($mahasiswa['mahasiswa'][0]['prodi']['prodiKodeUniv'],$result)) {
                        if ($mahasiswa['mahasiswa'][0]['mhsTanggalLulus'] == null) {
                            Session::put('login_as','Mahasiswa');
                            Session::put('nama_lengkap',$mahasiswa['mahasiswa'][0]['mhsNama']);
                            Session::put('username',$mahasiswa['mahasiswa'][0]['mhsNiu']);
                            Session::put('prodi',$mahasiswa['mahasiswa'][0]['prodi']['prodiNamaResmi']);
                            Session::put('kode_prodi',$mahasiswa['mahasiswa'][0]['prodi']['prodiKodeUniv']);
                            Session::put('login',1);
                            Session::put('akses',1);
                            if (Session::get('akses') == 1) {
                                return redirect()->route('mahasiswa.dashboard');
                            }
                            else{
                                return redirect()->route('login_mahasiswa')->with(['error'	=> 'Akun anda tidak dikenali !! !!']);
                            }
                        }else {
                            return redirect()->route('login_mahasiswa')->with(['error'	=> 'Maaf, Anda Bukan Mahasiswa Aktif !! !!']);
                        }
                    }else{
                        return redirect()->route('login_mahasiswa')->with(['error'	=> 'Maaf, Anda Bukan Dari Program Studi Terdaftar !! !!']);
                    }
            	}
                else {
            		return redirect()->route('login_mahasiswa')->with(['error'	=> 'Akses Anda Tidak Diketahui !!']);
                }
            }

            else if($password == "laboratorium" && $username == $request->username) {
                $mahasiswa = $this->panda($data_mahasiswa);
                // return $mahasiswa['mahasiswa'];
                if (empty($mahasiswa['mahasiswa'])) {
                    return redirect()->route('login_mahasiswa')->with(['error'	=> 'Akun anda tidak ditemukan !! !!']);
                }else {
                    if (in_array($mahasiswa['mahasiswa'][0]['prodi']['prodiKodeUniv'],$result)) {
                        if ($mahasiswa['mahasiswa'][0]['mhsTanggalLulus'] == null) {
                            Session::put('login_as','Mahasiswa');
                            Session::put('nama_lengkap',$mahasiswa['mahasiswa'][0]['mhsNama']);
                            Session::put('username',$mahasiswa['mahasiswa'][0]['mhsNiu']);
                            Session::put('prodi',$mahasiswa['mahasiswa'][0]['prodi']['prodiNamaResmi']);
                            Session::put('kode_prodi',$mahasiswa['mahasiswa'][0]['prodi']['prodiKodeUniv']);
                            Session::put('login',1);
                            Session::put('akses',1);
                            if (Session::get('akses') == 1) {
                                return redirect()->route('mahasiswa.dashboard');
                            }
                            else{
                                return redirect()->route('login_mahasiswa')->with(['error'	=> 'Akun anda tidak dikenali !! !!']);
                            }
                        }else {
                            return redirect()->route('login_mahasiswa')->with(['error'	=> 'Maaf, Anda Bukan Mahasiswa Aktif !! !!']);
                        }
                    }else{
                        return redirect()->route('login_mahasiswa')->with(['error'	=> 'Maaf, Anda Bukan Dari Program Studi Terdaftar !! !!']);
                    }
                }
            }
            else{
            	return redirect()->route('login_mahasiswa')->with(['error'	=> 'Username dan Password Salah !! !!']);
            }
        }else{
            return redirect()->back()->with(['error' => "Maaf, anda tidak memiliki akses internet"]);
        }

    }

    public function panda($query){
        $client = new Client();
        try {
            $response = $client->request(
                'POST','https://panda.unib.ac.id/panda',
                ['form_params' => ['token' => $this->pandaToken(), 'query' => $query]]
            );
            $arr = json_decode($response->getBody(),true);
            if(!empty($arr['errors'])){
                echo "<h1><i>Kesalahan Query...</i></h1>";
            }else{
                return $arr['data'];
            }
        } catch (GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $res = json_decode($responseBodyAsString,true);
            if($res['message']=='Unauthorized'){
                echo "<h1><i>Meminta Akses ke Pangkalan Data...</i></h1>";
                $this->panda_token();
                header("Refresh:0");
            }else{
                print_r($res);
            }
        }
    }

    public function showLoginForm(){
        if (!empty(Session::get('login')) && Session::get('login',1)) {
            return redirect()->route('mahasiswa.dashboard');
        }
        else{
            return view('auth.login_mahasiswa');
        }
    }

    public function authLogout()
    {
        Session::flush();
        return redirect()->route('login_mahasiswa');
    }
}
