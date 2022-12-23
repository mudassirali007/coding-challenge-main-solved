<?php

namespace App\Http\Controllers;

use App\Models\Request as RequestModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Session;

use function Symfony\Component\VarDumper\Cloner\dump;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with(compact([]));
    }

    public function removeConnection(Request $request){
        
        $data = $request->all();
        $userID = $data['userID'];
        $connectionID = $data['connectionID'];
        
        $record = RequestModel::where(function ($query) use ($userID, $connectionID) {
            $query->where(['sender_id'=> $userID, 'receiver_id'=> $connectionID])
                  ->orWhere(['sender_id'=> $connectionID, 'receiver_id'=> $userID]);
        });

        if($record->delete()){
            Session::flash('success_message', 'Connection Removed.');
        }
        else{
            Session::flash('error_message', 'Something went wrong. Try again.');
        }

        return true;
    }

    public function getSuggestions(Request $request){

        if($request->ajax()){
            $currentPage = $request->currentPage;
            $total = $request->total;
            
            if($currentPage > 0){
                $suggestions = Auth::user()->suggestions()->paginate($perPage=10, $total=$total, $page=$currentPage);
            }
            else{
                $suggestions = Auth::user()->suggestions()->paginate(10);
            }
            
            $output = '';

            if($suggestions->count() == 0){
              $output = "No suggestions Found.";
            }

            foreach($suggestions as $suggestion){
                
                $output .= '<div class="my-2 shadow  text-white bg-dark p-1" id="">
                <div class="d-flex justify-content-between">
                  <table class="ms-1">
                    <td class="align-middle">' .$suggestion->name. '</td>
                    <td class="align-middle"> - </td>
                    <td class="align-middle">'. $suggestion->email.' </td>
                    <td class="align-middle"> 
                  </table>
                  <div>
                    <button id="create_request_btn_" class="btn btn-primary me-1"
                        onclick="sendRequest('. Auth::user()->id .', '.$suggestion->id.')">Connect</button>
                  </div>
                </div>
              </div>';
            }
            
            $currentPage = $suggestions->currentPage();
            $total = $suggestions->total();

            $return_array = ['output' => $output, 'currentPage' => $currentPage, 'total' => $total];
            return json_encode($return_array);
        }
    }

    
    public function getRequests(Request $request){

        if($request->ajax()){
            $currentPage = $request->currentPage;
            $total = $request->total;
            $mode = $request->mode;
            
            if($currentPage > 0){

                if($mode == 'sent'){
                    $requests = Auth::user()->sentRequests->paginate($perPage=10, $total=$total, $page=$currentPage);
                }
                else{
                    $requests = Auth::user()->receivedRequests->paginate($perPage=10, $total=$total, $page=$currentPage);
                }
            }
            else{
          
              if($mode == 'sent'){
                $requests = Auth::user()->sentRequests->paginate(10);
              }
              else{
                $requests = Auth::user()->receivedRequests->paginate(10);
              }
            }
            
            $output = '';

            if($requests->count() == 0){
              $output = "No Requests Found.";
            }

            foreach($requests as $request){
              
                if($mode == "sent"){
                    $button = ' <div> <button id="cancel_request_btn_" class="btn btn-danger me-1"
                      onclick="deleteRequest('. $request->id .')">Withdraw Request</button>
                      </div></div></div>';

                      $request = $request->receiver;
                  }
                  else{
                    $button = '<div> <button id="accept_request_btn_" class="btn btn-primary me-1"
                    onclick="acceptRequest('. $request->id.')">Accept</button>
                    </div></div></div>';
                    $request = $request->sender;
                  }
                

                $output .= '<div class="my-2 shadow text-white bg-dark p-1">
                <div class="d-flex justify-content-between">
                  <table class="ms-1">
                      <td class="align-middle">'.$request->name.'</td>
                      <td class="align-middle"> - </td>
                      <td class="align-middle">'.$request->email.'</td>
                      <td class="align-middle">
                  </table>';

                 $output .= $button;
            }
            
            $currentPage = $requests->currentPage();
            $total = $requests->total();

            $return_array = ['output' => $output, 'currentPage' => $currentPage, 'total' => $total];
            return json_encode($return_array);
        }
    }

    public function getConnections(Request $request){

        if($request->ajax()){
            $currentPage = $request->currentPage;
            $total = $request->total;
            
            if($currentPage > 0){
                $connections = Auth::user()->connections()->paginate($perPage=10, $total=$total, $page=$currentPage);
            }
            else{
                $connections = Auth::user()->connections()->paginate(10);
            }
            
            $output = '';

            if($connections->count() == 0){
              $output = "No Connections Found.";
            }

            foreach($connections as $key=>$connection){

                $key = $key+10*$currentPage;
                
                //  If the loggedIn user is Sender then get Receiver data and vice versa.
                if($connection->sender_id == Auth::user()->id){
                  $connection = $connection->receiver;
                }
                else{
                  $connection = $connection->sender;
                }
                
                  /**
                   * Connections in Common: 
                   * First get both users connections then take their intersection
                   */
                  $userConnections = Auth::user()->connections();
                  $friendConnections = $connection->connections();

                  $userConnectionsIDs = $userConnections->map->only('sender_id','receiver_id')->flatten()->unique();
                  $friendConnectionsIDs = $friendConnections->map->only('sender_id','receiver_id')->flatten()->unique();
                  
                  $commonConnectionIDs = $userConnectionsIDs->intersect($friendConnectionsIDs);
                  $userID = Auth::user()->id;
                  $friendID = $connection->id;
                  // Remove current user and friend id and only keep common connection ids
                  $commonConnectionIDs =  $commonConnectionIDs->filter(function ($id, $key) use($userID, $friendID){
                    return $id != $userID & $id != $friendID;
                  });
                
                  $commonConnections = User::whereIn('id', $commonConnectionIDs->values()->all())->limit(10)->get();

                  $commonConnectionOutput = '';
                  foreach($commonConnections as $cc){
                   $commonConnectionOutput .= '<div class="p-2 shadow rounded mt-2  text-white bg-dark">'.$cc->name.' - '.$cc->email.'</div>'; 
                  }
                  // Connections in common button
                  if($commonConnections->count() == 0){
                    $commonConnectionButton = '<button style="width: 220px" id="get_connections_in_common_" class="btn btn-primary disabled" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse_'.$key.'" aria-expanded="false" aria-controls="collapseExample">
                    Connections in common () </button>';
                  }
                  else{
                    $commonConnectionButton = '<button style="width: 220px" id="get_connections_in_common_" class="btn btn-primary" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse_'.$key.'" aria-expanded="false" aria-controls="collapseExample">
                    Connections in common ('.$commonConnections->count().')
                  </button>';
                  }
                

                $output .= '<div class="my-2 shadow text-white bg-dark p-1" id="">
                <div class="d-flex justify-content-between">
                  <table class="ms-1">
                    <td class="align-middle">'. $connection->name.' </td>
                    <td class="align-middle"> - </td>
                    <td class="align-middle">'.$connection->email.'</td>
                    <td class="align-middle">
                  </table>
                  <div>'.$commonConnectionButton.' <button id="create_request_btn_" class="btn btn-danger me-1" 
                    onclick="removeConnection('. Auth::user()->id.', '.$connection->id.')">Remove Connection</button>
                  </div>
          
                </div>
                <div class="collapse" id="collapse_'.$key.'">
          
                  <div id="content_" class="p-2">
                    '.$commonConnectionOutput.'
                  </div>';

                  if($commonConnections->count() == 10){
                    $output .= '<div id="connections_in_common_skeletons_"></div>
                    <div class="d-flex justify-content-center w-100 py-2">
                      <button class="btn btn-sm btn-primary" id="load_more_connections_in_common_">Load more</button>
                    </div>';
                  }
                  $output .= ' </div></div>';

            }
            
            $currentPage = $connections->currentPage();
            $total = $connections->total();
            
            $return_array = ['output' => $output, 'currentPage' => $currentPage, 'total'=> $total];
            return json_encode($return_array);
        }
    }
}
