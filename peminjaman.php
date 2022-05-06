<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Buku.class.php");
include("includes/Peminjaman.class.php");
include("includes/Member.class.php");

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$buku = new Buku($db_host, $db_user, $db_pass, $db_name);
$peminjaman = new Peminjaman($db_host, $db_user, $db_pass, $db_name);
$member->open();
$buku->open();
$peminjaman->open();

if (isset($_POST['add'])) {
    //memanggil add

    print_r($_POST);
    $peminjaman->add($_POST);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_hapus'])) {
    //memanggil add
    $id_peminjaman = $_GET['id_hapus'];

    $peminjaman->delete($id_peminjaman);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_status'])) {
    //memanggil update status

    $peminjaman->updateStatus($_GET['id_status']);
    header("location:peminjaman.php");
}

$status = false;
$alert = null;
$data = null;
$no = 1;

$peminjaman->getPeminjaman();
while (list($id_peminjaman, $nim, $id_buku, $status) = $peminjaman->getResult()) {
    $member->getNamaByNim($nim);
    $data_nama = $member->getResult();
    $nama = $data_nama['nama'];

    $buku->getJudulById($id_buku);
    $data_judul = $buku->getResult();
    $judul_buku = $data_judul['judul_buku'];

    if ($status == "Sudah Dikembalikan") {
        $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $nama . "</td>
            <td>" . $judul_buku . "</td>
            <td>" . $status . "</td>
            <td>
            <a href='peminjaman.php?id_hapus=" . $id_peminjaman . "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
    }
    else {
        $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $nama . "</td>
            <td>" . $judul_buku . "</td>
            <td>" . $status . "</td>
            <td>
            <a href='peminjaman.php?id_status=" . $id_peminjaman . "' class='btn btn-warning' '>Update</a>
            <a href='peminjaman.php?id_hapus=" . $id_peminjaman . "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
    }
}


$dataNama = null;
$dataJudul = null;
$member->getMember();
while (list($nim, $nama) = $member->getResult()) {
    $dataNama .= "<option value='".$nim."'>".$nama."</option>";
}

$buku->getBuku();
while (list($id_buku, $judul_buku) = $buku->getResult()) {
    $dataJudul .= "<option value='".$id_buku."'>".$judul_buku."</option>";
}

$peminjaman->close();
$member->close();
$buku->close();
$tpl = new Template("templates/peminjaman.html");
$tpl->replace("OPTION_NAMA", $dataNama);
$tpl->replace("OPTION_JUDUL", $dataJudul);
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
