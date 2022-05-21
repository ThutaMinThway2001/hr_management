<x-app-layout>
    @section('title')
    <h4>HR_MANAGEMENT</h4>
    @endsection

    <div class="card">
        <div class="card-body text-center">
            <img src="{{asset('image/qr_scan.png')}}" style="width: 200px"  alt="">

            <p class="text-muted">Please scan attendance QR.</p>

<!-- Button trigger modal -->
<button type="button" class="btn btn-info" data-mdb-toggle="modal" data-mdb-target="#scanModal">
    Scan
  </button>
  
  <!-- Modal -->
  <div class="modal top fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
    <div class="modal-dialog  ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="scanModalLabel">QR Scanner</h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <video id="video"></video>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{asset('js/qr-scanner.umd.min.js')}}"></script>
    
        <script>
            $(document).ready(function(){
                var videoElem = document.getElementById('video');
                var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
                    keyboard: false
                })

                const qrScanner = new QrScanner(videoElem, function(result){
                    if(result){
                        myModal.hide();
                        qrScanner.stop();

                        $.ajax({
                            url: '/attendance/qrscan/store',
                            type: 'POST',
                            data: {"qr_scan" : result},
                            success: function(response){
                                if(response.status == 'success'){
                                    Toast.fire({
                                        icon: 'success',
                                        title: response.message
                                    })
                                }else{
                                    Toast.fire({
                                        icon: 'error',
                                        title: response.message
                                    })
                                }
                            }
                        })
                    }
                });

                const myModalEl = document.getElementById('scanModal')

                myModalEl.addEventListener('shown.bs.modal', event => {
                    qrScanner.start();
                });

                myModalEl.addEventListener('hidden.bs.modal', event => {
                    qrScanner.stop();
                });
            })
        </script>
    @endsection
</x-app-layout>
