<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Buku.class.php");
include("includes/Author.class.php");
include("includes/Member.class.php");

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();

$status = false;
$alert = null;
$input_form = null;
$title_form = null;

if (!empty($_GET['id_update'])) {
    $nim = $_GET['id_update'];

    $member->getMemberByNim($nim);
    $data_member = $member->getResult();
    $nama = $data_member['nama'];
    $jurusan = $data_member['jurusan'];

    $title_form .= "<h2 class='card-title'>Update Member</h2>";

    $input_form .=
    "
    <div class='form-row'>
        <div class='form-group col'>
            <label for='nim'>NIM</label>
            <input type='text' class='form-control' name='nim' value='$nim' readonly/>
        </div>
    </div>
    <div class='form-row'>
    <div class='form-group col'>
        <label for='nama'>Nama</label>
        <input type='text' class='form-control' name='nama' value='$nama' required />
    </div>
    </div>

    <div class='form-row'>
    <div class='form-group col'>
        <label for='jurusan'>Jurusan</label>
        <input type='text' class='form-control' name='jurusan' value='$jurusan' required></input>
    </div>
    </div>

    <button type='submit' name='save' class='btn btn-primary mt-3'>Save</button>
    ";
}else {
    $title_form .= "<h2 class='card-title'>Add Member</h2>";
    $input_form .= 
    "
    <div class='form-row'>
        <div class='form-group col'>
            <label for='nim'>NIM</label>
            <input type='text' class='form-control' name='nim' required />
        </div>
    </div>

    <div class='form-row'>
    <div class='form-group col'>
        <label for='nama'>Nama</label>
        <input type='text' class='form-control' name='nama' required />
    </div>
    </div>

    <div class='form-row'>
    <div class='form-group col'>
        <label for='jurusan'>Jurusan</label>
        <input type='text' class='form-control' name='jurusan' required></input>
    </div>
    </div>

    <button type='submit' name='add' class='btn btn-primary mt-3'>Add</button>
    ";
}

if (isset($_POST['add'])) {
    //memanggil add
    $member->add($_POST);
    header("location:member.php");
}

if (!empty($_GET['id_hapus'])) {
    //memanggil add
    $nim = $_GET['id_hapus'];

    $member->delete($nim);
    header("location:member.php");
}

if (isset($_POST['save'])) {
    //memanggil update

    $member->update($_POST);
    header("location:member.php");
}


$data = null;
$dataAuthor = null;
$no = 1;

$member->getMember();
while (list($nim, $nama, $jurusan) = $member->getResult()) {
    $data .= "<tr>
        <td>" . $no++ . "</td>
        <td>" . $nim . "</td>
        <td>" . $nama . "</td>
        <td>" . $jurusan . "</td>
        <td>
        <a href='member.php?id_update=" . $nim . "' class='btn btn-warning' '>Update</a>
        <a href='member.php?id_hapus=" . $nim . "' class='btn btn-danger' '>Hapus</a>
        </td>
        </tr>";
}

$member->close();
$tpl = new Template("templates/member.html");
$tpl->replace("TITLE_FORM", $title_form);
$tpl->replace("FORM", $input_form);
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
