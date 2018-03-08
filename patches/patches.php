<!DOCTYPE html>
<html>
  <head>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/staceticssakoznasbootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">

    <link rel="shortcut icon" type="image/png" href="logo.png"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/datetime-moment.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/locale/af.js"></script>
    <title>Patch 'em up</title>
  </head>
  <body>

<div class="container-fluid mainKlasa">
  <div class="row">
    <div class="col-md-8">
      <table id="patches" class="table table-striped table-bordered" cellspacing="0"></table>
    </div>
    <div class="col-md-4">
<form>
  <div class="form-group">
  <label for="faze">Faza radnih naloga</label>
  <select class="form-control" id="faze">
    <option>Tužbe</option>
    <option>Novi korisnik</option>
    <option>Otklanjanje kvara</option>
    <option>Zamjena uređaja</option>
  </select>
</div>
  <div class="form-group">
    <label for="fajl">Naziv fajla</label>
    <input type="text" class="form-control" id="fajl" placeholder="Unesi naziv fajla">
  </div>
  <div class="form-group">
    <label for="patchDscrb">Izmjene u novoj verziji</label>
    <textarea class="form-control noresize" id="patchDscrb" rows="8"></textarea>
  </div>
  <div class="form-group">
  <label for="korisnik">Korisnik</label>
  <select class="form-control" id="korisnik">
    <option>Radenko Kokanović</option>
    <option>Nemanja Tomanović</option>
    <option>Damir Zečević</option>
  </select>
</div>
  <button type="button" class="btn btn-outline-primary" onclick="posaljiPodatke();"><i class="fas fa-check"></i> <strong>Prihvati</strong></button>
<hr>
</form>
<div id="cpPatches">
    <p>Control panel</p>
</div>

<div class="container-fluid">
  <div class="row">
    <button type="button" class="btn btn-outline-success col-lg-6" id="dokumentacija"><i class="far fa-file-alt"></i> <strong> Dokumentacija</strong></button>
    <button type="button" class="btn btn-outline-danger col-lg-6" id="dugmeBrisanje" disabled><i class="fas fa-eraser"></i><strong> Obriši izmjenu</strong></button>
    <button type="button" class="btn btn-outline-success col-lg-12" id="pregledFajla" disabled><i class="far fa-file-alt"></i> <strong>Otvori fajl</strong></button>
  </div>
  </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$('#dokumentacija').on('click',function() {
  window.open('CRMdokumentacija.pdf','_blank');
})
var tabelaPatch,nazivFajlaIzGrida;
$.ajax({
  //test
url:'citajNaziveFajlova.php',
type: 'POST',
dataType: 'JSON',
success:function(data){
  console.log(data);
  tabelaPatch = $('#patches').DataTable({
    data: data.data,
    responsive:true,
    fixedHeader:true,
    processing: true,
    pageLength: 10,
    select:{
      style:"single",
      info: false
    },
    language:{
      paginate:{
        first:"Prva",
        last:"Poslednja",
        next:"Sledeća",
        previous:"Prethodna"
      },
      emptyTable: "Nema podataka u tabeli",
      lengthMenu: "Prikaz _MENU_ unosa",
      search:     "Pretraga:",
      info:       "Prikazujem _START_ do _END_ od _TOTAL_ unosa",
      processing:  "Obrada..."
    },
      order: [[ 0, "desc" ]],
  columns:[
    {data:'fajl',orderable:true,title:'Naziv dokumenta'},
    {data:'faza',orderable:true,title:'Faza'},
    {data:'korisnik',orderable:true,title:'Korisnik'},
    {data:'datum',orderable:true,title:'Datum'}
  ]
  });
  tabelaPatch.on('select', function(e, dt, type, indexes) {
    $('#dugmeBrisanje').prop('disabled',false);
    $('#pregledFajla').prop('disabled',false);
    nazivFajlaIzGrida = tabelaPatch.rows(indexes).data()[0].fajl;
      $('#dugmeBrisanje').on('click',function(event) {

        $.alert({
          title: 'Brisanje',
          content:'Da li ste sigurni da želite da obrišete sledeći dokument <ol><li>'+nazivFajlaIzGrida+'</li></ol>',
          columnClass: 'medium',
          animationSpeed: 750,
          icon: 'fas fa-exclamation-triangle',
          animation: 'zoom',
          closeAnimation: 'scale',
          buttons:{
            ok: {
              text: 'OK',
              btnClass: 'btn-danger',
              action: function(){
                $.ajax({
                  type:'POST',
                  url:'brisiFajl.php',
                  data:{'fajl':nazivFajlaIzGrida}
                }).done(function() {
                  $.alert({
                    title:'Uspješnо!',
                    icon:'fa fa-check',
                    content:'Uspješno ste obrisali fajl.',
                    type:'green',
                    buttons:{
                      ok:{
                        text:'OK!',
                        btnClass:'btn-primary',
                        action:function() {
                          $('fajl').text('');
                          $('patchDscrb').text('');
                          location.reload();
                        }
                      }
                    }
                  })
                }).fail(function() {
                  $.alert({
                    title:'Neuspješnо!',
                    icon:'fa fa-warning',
                    content:'Fajl nije obrisan!',
                    type:'red',
                    animation: 'zoom',
                    closeAnimation: 'scale',
                    buttons:{
                      ok:{
                        text:'OK!',
                        btnClass:'btn-danger',
                        action:function() {
                          $('fajl').text('');
                          $('patchDscrb').text('');
                          location.reload();
                        }
                      }
                    }
                  })
                })
              }
          },
          zatvori:{
            text:'Odustani',
            icon:'fas fa-minus-circle'
          }
          },
          type:'red',
          theme:'material'
            });
            })



    })

    $('#pregledFajla').on('click',function() {
      //nazivFajlaIzGrida = null;
      var currentElem = $(this);
      //nazivFajlaIzGrida = tabelaPatch.rows(indexes).data()[0].fajl;
      console.log(nazivFajlaIzGrida);
      $.ajax({
          type:'POST',
          url: 'citajFajl.php',
          data:{'nazivFajla':nazivFajlaIzGrida},
          success:function(resData) {
            $.alert({
              title: 'Izmjene u trenutnom patchu',
              icon: 'far fa-question-circle',
              animation: 'zoom',
              closeAnimation: 'scale',
               columnClass: 'col-md-12',
              buttons:{
                ok: {
                  text: 'OK',
                  btnClass: 'btn-primary',
                  action:function() {
                    }
              }
              },
              content: resData,
              type:'blue',
              theme:'material'
                });
          },
          error: function() {
            console.log('greska');
          }
      })

  })

    tabelaPatch.on('deselect', function(e, dt, type, indexes) {
      $('#dugmeBrisanje').prop('disabled',true);
      $('#pregledFajla').prop('disabled',true);
      })

}
});




function posaljiPodatke () {
  var imefajla,faza,korisnik,sadrzaj,datum
    var trenutno = new Date();

    imeFajla = document.getElementById('fajl').value+".txt";
    faza = document.getElementById('faze').value;
    korisnik = document.getElementById('korisnik').value;
    sadrzaj = document.getElementById('patchDscrb').value;
    datum = moment(trenutno).format('YYYY-MM-DD HH:MM:SS');


    var nizPodataka = {"imeFajla":imeFajla,"faza":faza,"korisnik":korisnik,"datum":datum,"sadrzaj":sadrzaj}
    var jsonNiz = JSON.stringify(nizPodataka);
  $.ajax({
    type: 'POST',
    url:"napraviFajl.php",
    data:{'imeFajla':nizPodataka['imeFajla'],'sadrzaj':jsonNiz},
    success:function(data) {
      $.alert({
        title: 'Uspješno!',
        icon: 'fa fa-check',
        animationSpeed: 750,
        animation: 'zoom',
        closeAnimation: 'scale',
        buttons:{
          ok: {
            text: 'OK',
            btnClass: 'btn-primary',
            action: function(){
              console.log('testiranje');
              $('fajl').text('');
              $('patchDscrb').text('');
                location.reload();

            }
        }
        },
        content: 'Dodavanje fajla uspjelo!',
        type:'blue',
        theme:'material'
          });
    },
    error:function(jqXHR) {
      console.log(jqXHR.readyState + " " + jqXHR.status);
      $.alert({
        title: 'Neuspješno!',
        icon: 'fa fa-warning',
        animation: 'zoom',
        closeAnimation: 'scale',
        buttons:{
          ok: {
            text: 'OK',
            btnClass: 'btn-danger',
            action: function(){
              $('fajl').text('');
              $('patchDscrb').text('');
                location.reload();
            }
        }
        },
        content: 'Dodavanje fajla nije uspjelo!',
        type:'red',
        theme:'material'
          });
    }
  });
}

</script>
  </body>
</html>
