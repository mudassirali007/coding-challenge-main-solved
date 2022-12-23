<div class="row justify-content-center mt-5">
  <div class="col-12">
    <div class="card shadow  text-white bg-dark">
      <div class="card-header">Coding Challenge - Network connections</div>
      
      <div class="card-body">
        <div class="btn-group w-100 mb-3" role="group" aria-label="Basic radio toggle button group">
          <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
          <label class="btn btn-outline-primary" for="btnradio1" id="get_suggestions_btn">Suggestions ()</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
          <label class="btn btn-outline-primary" for="btnradio2" id="get_sent_requests_btn">Sent Requests ()</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
          <label class="btn btn-outline-primary" for="btnradio3" id="get_received_requests_btn">Received
            Requests()</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
          <label class="btn btn-outline-primary" for="btnradio4" id="get_connections_btn">Connections ()</label>
        </div>
        <hr>
        <div id="content" class="">
         
          {{-- For Success Messages --}}
            @if(Session::has('success_message'))

            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('success_message') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- For Errors --}}
            @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ Session::get('error_message') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
    
          {{-- Display data here --}}
          <div class="suggestions_tab">
            <span class="fw-bold">Suggestions Blade</span>
            <x-suggestion />
          </div>
          
        <div class="sent_requests_tab d-none">
          <span class="fw-bold">Sent Request Blade</span>
          <x-request :mode="'sent'" />
        </div>

        <div class="received_requests_tab d-none">
          <span class="fw-bold">Received Request Blade</span>
          <x-request :mode="'received'" />
        </div>

        <div class="connections_tab d-none">
          <span class="fw-bold">Connection Blade</span>
          <x-connection />
        </div>

        </div>

      
        
      </div>
    </div>
  </div>
</div>