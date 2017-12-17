<div class="modal fade" id="progresLoading" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
                <div class="modal-body">
                  <div class="box box-danger">
                      <div class="box-header">
                      </div>
                      <div class="box-body">
                      </div>
                      <div class="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                      </div>
                  </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="vertical-alignment-helper">
          <div class="modal-dialog vertical-align-center">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>

                      </button>
                       <h4 class="modal-title" id="myModalLabel">Success</h4>

                  </div>
                  <div class="modal-body">
                    <p></p>
                  </div>

              </div>
          </div>
      </div>
  </div>

<section class="content-header">
      <h5>
         <ul class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Product</li>
      </ul>
      </h5>
    </section>

<section class="content">
	 <div class="box box-primary" style="padding: 10pt">
            <div class="box-header with-border">
              <h3 class="box-title"> Tambah Produk</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <?php if(is_numeric($id)){ ?>
                <div class="box-body prod">
                  <div class="form-group">
                    <label for="judul">Nama Produk</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama Obat " value="<?=$row_produk['nm_produk'];?>">
                    <div class="error" id="ntf_nama"></div>
                  </div>

                  <div class="form-group">
                  	<label for="desc">Deskripsi Produk</label>
                  	<textarea name="desc" id="desc">
                  		<?=$row_produk['desc_produk'];?>
                  	</textarea>
                    <div class="error" id="ntf_desc"></div>
                  </div>

                  <div class="form-group">
                    <label for="content">Harga</label>
                     <input type="text" class="form-control" id="harga" name="harga" name="coba" placeholder="Masukan Harga" value="<?=$row_produk['price_produk'];?>">
                    <div class="error" id="ntf_harga"></div>
                  </div>

                  <div class="form-group">
                    <label for="content">Harga Khusus</label>
                     <input type="text" class="form-control" id="harga_khusus" name="harga_khusus" name="coba" placeholder="Masukan Harga khusus items" value="<?=$row_produk['harga'];?>">
                    <div class="error" id="ntf_harga_khusus"></div>
                  </div>

                  <div class="form-group">
                    <label for="poto">Pilih Gambar</label>
                    <input type="file" class="gambar" name="gambar">

                    <p class="help-block">Masukan Gambar Yang Akan Ditampilkan Di Atrikel</p>
                    <div class="error" id="ntf_error"></div>
                  </div>
                  <!-- <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add More</button> -->
                  <div class="form-group">
                    <div class="col-md-4 well">
                      <img src="<?=base_url();?>uploads/product/thumb/<?=$row_produk['photo_produk'];?>" style="width: 100%;">
                    </div>
                  </div>
                </div>
              <?php }else{ ?>
                <div class="box-body prod">
                  <div class="form-group">
                    <label for="judul">Nama Produk</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama Obat">
                    <div class="error" id="ntf_nama"></div>
                  </div>

                  <div class="form-group">
                  	<label for="desc">Deskripsi Produk</label>
                  	<textarea name="desc" id="desc">
                  	</textarea>
                    <div class="error" id="ntf_desc"></div>
                  </div>

                  <div class="form-group">
                    <label for="content">Harga</label>
                     <input type="text" class="form-control" id="harga" name="harga" name="coba" placeholder="Masukan Harga">
                    <div class="error" id="ntf_harga"></div>
                  </div>

                  <div class="form-group">
                    <label for="content">Harga Khusus</label>
                     <input type="text" class="form-control" id="harga_khusus" name="harga_khusus" name="coba" placeholder="Masukan Harga khusus items">
                    <div class="error" id="ntf_harga_khusus"></div>
                  </div>

                  <div class="form-group">
                    <label for="poto">Pilih Gambar</label>
                    <input type="file" class="gambar" name="gambar[]">

                    <p class="help-block">Masukan Gambar Yang Akan Ditampilkan Di Atrikel</p>
                    <div class="error" id="ntf_error"></div>
                    <!-- <button type="button" class="btn btn-success"  id="add"><i class="fa fa-plus"></i> Add More</button> -->
                  </div>
                </div>
              <?php } ?>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="button" id="btn_save" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>

</section>

<script src="<?=base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type='text/javascript'>
var dom = {};
dom.query = jQuery.noConflict( true ); 
  dom.query(document).ready(function() {
    dom.query('#modal-default').on('hidden.bs.modal', function () {
        dom.query('body').removeAttr('style');
    });

    dom.query('body').on('click','#add', function(){
      var n = dom.query('.gambar').length;
      console.log(n);
      var contentwe = '<div class="form-group"> <label for="poto">Pilih Gambar</label> <input type="file" class="gambar" name="gambar[]"><p class="help-block">Masukan Gambar Yang Akan Ditampilkan Di Atrikel</p><div class="error" id="ntf_error_'+n+'"></div><button type="button" class="btn btn-success"  id="add"><i class="fa fa-plus"></i> Add More</button>   <button type="button" class="btn btn-danger"  id="remove"><i class="fa fa-minus"></i> remove</button></div>';
      dom.query('.prod').append(contentwe);
    });

    dom.query('body').on('click','#btn_save',function(){

      var file_data = dom.query('.gambar').prop('files')[0];
      var value = CKEDITOR.instances['desc'].getData();
      var form_data = new FormData();
      form_data.append('nama',dom.query('#nama').val());
      form_data.append('harga',dom.query('#harga').val());
      form_data.append('harga_khusus',dom.query('#harga_khusus').val());
      form_data.append('desc',value);
      form_data.append('gambar',file_data);
      $('.error').html('');
      if (dom.query('#nama').val() == '') {
      	dom.query('#ntf_nama').html('The Nama Produk field is required.');
        dom.query('#ntf_nama').css({'color':'red', 'font-style':'italic'});
      }
       if (dom.query('#harga').val() == '') {
      	dom.query('#ntf_harga').html('The Harga Produk field is required.');
        dom.query('#ntf_harga').css({'color':'red', 'font-style':'italic'});
      }
      if (value == '') {
      	dom.query('#ntf_desc').html('The Deskripsi Produk field is required.');
        dom.query('#ntf_desc').css({'color':'red', 'font-style':'italic'});
      }
      console.log(value);
      <?php if (is_numeric($id)) { ?>
        if (file_data) {
          if(file_data.type != 'image/jpeg' && file_data.type != 'image/jpg' && file_data.type != 'image/png'){
            $('#myModal').modal('show');
              dom.query('#myModalLabel').html('Failed');
              dom.query('#myModal .modal-body p').html('Format Gambar Tidak Sesuai');
              return false;
          }
          // check file data size that allowed to upload
          var fileSize = 0;
          if (file_data.size > 2 * 1024 * 1024){
              fileSize = (Math.round(file_data.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
              $('#myModal').modal('show');
              dom.query('#myModalLabel').html('Failed');
              dom.query('#myModal .modal-body p').html('Ukuran Gambar Terlalu besar Max 2MB');
              return false;
          }
        }
      <?php }else{ ?>
        var ret = 1;
        // dom.query('.gambar').each(function(k,v){
        //   console.log(k);
        //   console.log(dom.query(this).val());
        //   console.log(dom.query(this).prop('files')[0]);
        //   // console.log(dom.query('.gambar').prop('files')[0]);
        if (dom.query('.gambar').prop('files')[0] == undefined) {
                dom.query('#ntf_error').html('Select an Image');
                dom.query('#ntf_error').css({'color':'red', 'font-style':'italic'});
                console.log('gagal');
                ret = 0
          }
            // file_data.push(dom.query(this).prop('files')[0]);
            // console.log(file_data[k].type);
            if(file_data.type != 'image/jpeg' && file_data.type != 'image/jpg' && file_data.type != 'image/png'){
              $('#myModal').modal('show');
                dom.query('#myModalLabel').html('Failed');
                dom.query('#myModal .modal-body p').html('Format Gambar Tidak Sesuai');
                ret = 0;
            }
        //   }
        // });

        if (ret == 0) {
          return false;
        }
      // console.log(file_data[0]);
      // form_data.append('gambar',file_data);

      
      // check file data size that allowed to upload
      var fileSize = 0;
      if (file_data.size > 2 * 1024 * 1024){
          fileSize = (Math.round(file_data.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
          $('#myModal').modal('show');
          dom.query('#myModalLabel').html('Failed');
          dom.query('#myModal .modal-body p').html('Ukuran Gambar Terlalu besar Max 2MB');
          return false;
      }
        <?php } ?>
      dom.query.ajax({
         xhr: function() {
              var xhr = new window.XMLHttpRequest();
          console.log('runing');
              xhr.upload.addEventListener("progress", function(evt) {
                $('#progresLoading').modal('show');
                if (evt.lengthComputable) {
                  if (percentComplete === 100) {
                     setTimeout(function(){ 
                      $('#progresLoading').modal('hide');
                      }, 2000);
                  }
                }
              }, false);
              return xhr;
          },
        beforeSend: function( xhr ) {
            $('#progresLoading').modal('show');
            setTimeout(function() {}, 1000);
        },
        url : '<?=current_url();?>',
        type : 'POST',
        dataType : 'json',
        data : form_data ,
        async : false,
        cache : false ,
        contentType : false , 
        processData : false
     }).done(function(data){
            $('#progresLoading').modal('hide');
        if (data.state == 1) {
          if (data.status == 1 ) {
            $('#myModal').modal('show');
            dom.query('#myModal .modal-body p').html(data.text);
            <?php if (!is_numeric($id)) { ?>
              dom.query('#nama').val('');
              dom.query('#alamat').val('');
              dom.query('#harga').val('');
              dom.query('#gambar').val('');
              dom.query('#harga_khusus').val('');
              CKEDITOR.instances.desc.setData("");
            <?php } ?>
            dom.query('.error').html('');
            console.log(data.text);
          }else{
            console.log('gagal'); 
          }
        }else{
          dom.query.each(data.notif,function(key,value){
            dom.query('.error').show();
            dom.query('#ntf_'+key).html(value);
            dom.query('#ntf_'+key).css({'color':'red', 'font-style':'italic'});
          });
          console.log(data.notif);
        }
      }).fail(function(xhr, status, error){
        alert(xhr.respondtext);
      });
    });

dom.query('body').on('click','#remove',function(){
      console.log('jalan');
      dom.query(this).parent().remove();
    });
	
	CKEDITOR.replace('desc');
  });
</script>