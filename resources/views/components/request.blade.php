@if ($mode == 'sent')

  <div id="sent_requests">
    <div id="content"></div>
   
      <div class="d-flex justify-content-center mt-2 py-3" id="load_more_sent_requests_btn_parent">
        <button class="btn btn-primary" id="load_more_sent_requests_btn" data-total="" 
          data-currentPage="" onclick="getMoreRequests('{{ $mode }}')">Load more</button>
      </div>
      <div id="skeleton" class="d-none"> 
      <x-skeleton /> 
      </div>
    </div>
  </div>
@else
    <div id="received_requests">
      
      <div id="content"></div>
      
      <div class="d-flex justify-content-center mt-2 py-3" id="load_more_received_requests_btn_parent">
        <button class="btn btn-primary" id="load_more_received_requests_btn" data-total="" 
          data-currentPage="" onclick="getMoreRequests('{{ $mode }}')">Load more</button>
      </div>
      <div id="skeleton" class="d-none"> 
      <x-skeleton /> 
      </div>
    </div>
@endif