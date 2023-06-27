<?php
  session_start();
  include("config.php");

  $username = $_SESSION['username'];

  if (isset($_GET['id_penawaran'])){
    $id_penawaran = $_GET['id_penawaran'];
  } else {
    $sql_penawaran = "SELECT * FROM penawaran ORDER BY id DESC LIMIT 1";
    $query_penawaran = mysqli_query($conn,$sql_penawaran);
    if (mysqli_num_rows($query_penawaran) > 0) {
      while ($row = mysqli_fetch_assoc($query_penawaran)) {
        $id_penawaran = $row['id'];
      }
    } else {
      echo "<script>alert('Kamu harus melakukan penawaran terlebih dahulu!');</script>";
      header("location: index.php");
    }
  }

  $sql = "SELECT p.*,
          b1.nama AS nama_barang1, b1.nama_file AS file_barang1, b1.username AS usn_barang1,
          b2.nama AS nama_barang2, b2.nama_file AS file_barang2, b2.username AS usn_barang2
          FROM penawaran AS p
          JOIN barang AS b1 ON p.id_barang1 = b1.id
          JOIN barang AS b2 ON p.id_barang2 = b2.id
          WHERE (b1.username = '$username' OR b2.username = '$username')
          ORDER BY p.id DESC";

  $query = mysqli_query($conn, $sql);
  $penawaranData = array();

  if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
      $id_tawar = $row['id'];
      $id_barang1 = $row['id_barang1'];
      $id_barang2 = $row['id_barang2'];
      $tambah_harga = $row['tambah_harga'];
      $nama_barang1 = $row['nama_barang1'];
      $file_barang1 = $row['file_barang1'];
      $usn_barang1 = $row['usn_barang1'];
      $nama_barang2 = $row['nama_barang2'];
      $file_barang2 = $row['file_barang2'];
      $usn_barang2 = $row['usn_barang2'];

      // Buat array untuk setiap penawaran
      $itemData = array(
        'id_tawar' => $id_tawar,
        'id_barang1' => $id_barang1,
        'id_barang2' => $id_barang2,
        'tambah_harga' => $tambah_harga,
        'nama_barang1' => $nama_barang1,
        'file_barang1' => $file_barang1,
        'usn_barang1' => $usn_barang1,
        'nama_barang2' => $nama_barang2,
        'file_barang2' => $file_barang2,
        'usn_barang2' => $usn_barang2
      );

      // Masukkin ke array penawaranData
      $penawaranData[] = $itemData;
    }
  }

  if (isset($_POST['simpan'])) {
    $id_barang2_new = $_POST['pilih-barang'];
    $tambah_harga_new = $_POST['tambah_harga'];

    $updateSql = "UPDATE penawaran SET id_barang2 = '$id_barang2_new' WHERE id = $id_penawaran";
    mysqli_query($conn, $updateSql);
    $updateSql = "UPDATE penawaran SET tambah_harga = '$tambah_harga_new' WHERE id = $id_penawaran";
    mysqli_query($conn, $updateSql);
  
    header("location: chat.php?id_penawaran=$id_penawaran");
    exit();
  }

  if (isset($_POST['batal']) || isset($_POST['tolak'])) {
    $deleteSql = "DELETE FROM penawaran WHERE id = $id_penawaran";
    mysqli_query($conn, $deleteSql);
    header("location: chat.php");
    exit();
  }

  if (isset($_POST['terima'])){
    $sql_kesepakatan = "INSERT INTO kesepakatan(id_penawaran) VALUES ('$id_penawaran')";
    mysqli_query($conn, $sql_kesepakatan);

    $updateSql = "UPDATE barang SET ketersediaan = 0 WHERE id = $id_barang1";
    mysqli_query($conn, $updateSql);
    $updateSql = "UPDATE barang SET ketersediaan = 0 WHERE id = $id_barang2";
    mysqli_query($conn, $updateSql);

    echo "<script>alert('Kamu berhasil melakukan kesepakatan!');</script>";
    header("location: index.php");
    exit();
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Chat</title>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <!-- Bootstrap -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <!-- Font awesome -->
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
    />

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="style_chat.css" />
  </head>
  <body>
    <!--Card Bagian kiri-->
    <!--container-fluid & row justify-content-center h-100-->
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-4 col-xl-3 chat">
          <div class="card mb-sm-3 mb-md-0 contacts_card">
            <div class="card-header">
              <div class="input-group">
                <input
                  type="text"
                  placeholder="Search messages"
                  name=""
                  class="form-control search"
                />
                <div class="input-group-prepend">
                  <span class="input-group-text search_btn"
                    ><i class="fas fa-search"></i
                  ></span>
                </div>
              </div>
            </div>
            <div class="card-body contacts_body">
              <ui class="contacts">
              <?php
                foreach ($penawaranData as $itemData) {
                  $id_tawar = $itemData['id_tawar'];
                  $id_barang1 = $itemData['id_barang1'];
                  $id_barang2 = $itemData['id_barang2'];
                  $tambah_harga = $itemData['tambah_harga'];
                  $nama_barang1 = $itemData['nama_barang1'];
                  $file_barang1 = $itemData['file_barang1'];
                  $usn_barang1 = $itemData['usn_barang1'];
                  $nama_barang2 = $itemData['nama_barang2'];
                  $file_barang2 = $itemData['file_barang2'];
                  $usn_barang2 = $itemData['usn_barang2'];

                  if ($id_tawar == $id_penawaran){
                    $isActive = "active";
                  } else {
                    $isActive = "";
                  }

                  if ($username == $usn_barang1){
                    $usn = $usn_barang2;
                  } else {
                    $usn = $usn_barang1;
                  }

                  echo '<li class="'.$isActive.'">
                          <a href="chat.php?id_penawaran='.$id_tawar.'">
                            <div class="d-flex bd-highlight">
                              <div class="img_cont">
                                <img
                                  src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg"
                                  class="rounded-circle user_img"
                                />
                                <span class="online_icon"></span>
                              </div>
                              <div class="user_info">
                                <span>'. $usn . '</span>
                                <div class="judul-product">
                                  <p>'. $nama_barang1 .'&emsp13;
                                  <img src="file/'. $file_barang1 .'"
                                  width="40px" height="40px" style="object-fit: cover"/>
                                  </p>
                                </div>
                                <p>
                                  <b
                                    >You offered Rp' . number_format($tambah_harga) .'&emsp13;
                                    <img src="file/'. $file_barang2 .'"
                                    width="30px" height="30px" style="object-fit: cover"/></b>
                                </p>
                              </div>
                            </div>
                          </a>
                        </li>';
                }
              ?>
              </ui>
            </div>
            <div class="card-footer"></div>

            <!--Card Bagian Kanan-->
          </div>
        </div>
        <!--col-md-8 col-xl-6 chat-->
        <?php
          $sql_chat = "SELECT p.*,
                      b1.nama AS nama_barang1, b1.nama_file AS file_barang1, b1.username AS usn_barang1,
                      b2.nama AS nama_barang2, b2.nama_file AS file_barang2, b2.username AS usn_barang2
                      FROM penawaran AS p
                      JOIN barang AS b1 ON p.id_barang1 = b1.id
                      JOIN barang AS b2 ON p.id_barang2 = b2.id
                      WHERE (b1.username = '$username' OR b2.username = '$username')
                      AND p.id = $id_penawaran";

          $query_chat = mysqli_query($conn, $sql_chat);

          if (mysqli_num_rows($query_chat) > 0) {
            $row = mysqli_fetch_assoc($query_chat);
            $id_tawar = $row['id'];
            $id_barang1 = $row['id_barang1'];
            $id_barang2 = $row['id_barang2'];
            $tambah_harga = $row['tambah_harga'];
            $nama_barang1 = $row['nama_barang1'];
            $file_barang1 = $row['file_barang1'];
            $usn_barang1 = $row['usn_barang1'];
            $nama_barang2 = $row['nama_barang2'];
            $file_barang2 = $row['file_barang2'];
            $usn_barang2 = $row['usn_barang2'];
          }

          if ($username == $usn_barang1){
            $usn = $usn_barang2;
          } else {
            $usn = $usn_barang1;
          }
        ?>
        <div class="col-md-8 col-xl- chat">
          <div class="card">
            <div class="card-header msg_head">
              <div class="d-flex bd-highlight">
                <div class="img_cont">
                  <img
                    src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg"
                    class="rounded-circle user_img"
                  />
                  <span class="online_icon"></span>
                </div>
                <div class="user_info">
                  <span><?= $usn ?></span>
                  <p>Online</p>
                </div>
                <?php $getData = $conn->query("SELECT * FROM barang");?>
              <?php while ($barang = $getData->fetch_assoc()){ ?>
                <span id="action_menu_btn">
                  <a class="back" href="view.php?id=<?= $id_barang1 ?>">
                    <p> > </p> 
                  </a>
                </span>
               <?php }?>
              </div>
            </div>
            <div class="card-body msg_card_body">
              <div class="produk d-flex justify-content-between left">
                <div class="d-flex">
                  <div class="img_cont">
                    <img src="file/<?= $file_barang1 ?>" alt="foto" />
                  </div>
                  <div class="product_show_info">
                    <span><?= $nama_barang1 ?></span>
                  </div>
                </div>
                <div class="d-flex">
                  <div class="img_cont">
                    <img src="file/<?= $file_barang2 ?>" alt="foto" />
                  </div>
                  <div class="product_show_info">
                    <span><?= $nama_barang2 ?></span>
                    <p><b>Rp<?= number_format($tambah_harga) ?></b></p>
                  </div>
                </div>

                <form method="post">
                <div class="btn d-flex justify-content-between right">
                  <div
                  <?php
                    if ($username != $usn_barang2){
                      echo "style='display: none'";
                    } else {
                      echo "style='display: block'";
                    }
                  ?>>
                    <button class="btn-1" name="ubah" onclick="openPopup()">Ubah</button>
                    <input type="submit" class="btn-2" name="batal" value="Batalkan">
                  </div>
                  <div
                  <?php
                    if ($username != $usn_barang1){
                      echo "style='display: none'";
                    } else {
                      echo "style='display: block'";
                    }
                  ?>>
                    <input type="submit" class="btn-1" name="terima" value="Terima">
                    <input type="submit" class="btn-2" name="tolak" value="Tolak">
                  </div>
                </div>
              </div>
              </form>

              <!-- Popup -->
              <div id="popup" class="popup">
                <div class="popup-content">
                  <span class="close" onclick="closePopup()">&times;</span>
                  <form method="post" action="">
                    <div class="box-1">
                      <h5>Ubah Penawaran</h5>
                      <select name="pilih-barang" id="pilih-barang" required>
                        <option selected disabled value="<?= $id_barang2 ?>"><?= $nama_barang2 ?></option>
                        <?php
                          $sql= "SELECT * FROM barang WHERE username = '$username'";
                          $query = mysqli_query($conn,$sql);
                          if (mysqli_num_rows($query)>0){
                            while ($row = mysqli_fetch_assoc($query)) {
                              echo '<option value="' . $row['id'] . '" data-image-src="file/' . $row['nama_file'] . '" data-placeholder="' . number_format($view['harga'] - $row ['harga']) . '">' . $row['nama'] . '</option>';
                            }
                          }
                        ?>
                      </select>
                      <div class="box-1-1">
                        <center><img id="selected-image" src="file/<?= $file_barang2 ?>" width="150px" height="150px"></center>
                      </div>
                      <div class="harga">
                        <label>Harga</label>
                      </div>
                      <div class="harga">
                        <input id="placeholder-input" type="text" value="<?= $tambah_harga ?>" name="tambah_harga" required>
                      </div>
                      <input type="submit" name="simpan" class="simpan" value="Simpan">
                    </div>
                  </form>
                </div>
              </div>
          
              <!--Chat-->
              <div class="d-flex justify-content-end mb-4">
                <div class="msg_cotainer_send">
                  <p>Made offer</p>
                  <p>
                    <img src="file/<?= $file_barang2 ?>" alt="foto novel A" />
                    <br>Rp<?= number_format($tambah_harga) ?>
                  </p>
                  <span class="msg_time_send">8:55 AM, Today</span>
                </div>
              </div>
              <div class="d-flex justify-content-start mb-4">
                <div class="msg_cotainer">
                  Maaf kak, aku udah ada barang itu. Kalo novel C ada?
                  <span class="msg_time">9:00 AM, Today</span>
                </div>
              </div>
              <div class="d-flex justify-content-end mb-4">
                <div class="msg_cotainer_send">
                  yah gaada kak kalo ini gimana?
                </div>
              </div>
              <div class="d-flex justify-content-end mb-4">
                <div class="msg_cotainer_send">
                <p>Made offer</p>
                  <p>
                    <img src="file/<?= $file_barang2 ?>" alt="foto novel A" />
                    <br>Rp<?= number_format($tambah_harga) ?>
                  </p>
                  <span class="msg_time_send">9:10 AM, Today</span>
                </div>
              </div>
              <div class="d-flex justify-content-start mb-4">
                <div class="msg_cotainer">
                  Boleh kak tp nambah 20k gapapa?
                  <span class="msg_time">9:12 AM, Today</span>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="input-group">
                <div class="typing-area">
                  <div class="input-field">
                    <input
                      type="text"
                      placeholder="Type your message"
                      required
                    />
                    <button>Send</button>
                  </div>
                  <div class="icon-gambar">
                    <button class="fas fa-image"></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="scripts.js"></script>
    <script>
      function openPopup() {
        var popup = document.getElementById("popup");
        popup.style.display = "block";
      }

      function closePopup() {
        var popup = document.getElementById("popup");
        popup.style.display = "none";
      }
      
      const selectElement = document.getElementById('pilih-barang');
      const imageElement = document.getElementById('selected-image');
      const placeholderInput = document.getElementById('placeholder-input');

      selectElement.addEventListener('change', function() {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const selectedImageSrc = selectedOption.getAttribute('data-image-src');
        const selectedPlaceholder = parseFloat(selectedOption.getAttribute('data-placeholder'));

        imageElement.src = selectedImageSrc;
        if(selectedPlaceholder <= 0.00){
          placeholderInput.value = 0.00;
        } else {
          placeholderInput.value = selectedPlaceholder;
        }
      });
    </script>
  </body>
</html>