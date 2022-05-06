<?php

class Peminjaman extends DB
{
    function getPeminjaman()
    {
        $query = "SELECT * FROM peminjaman";
        return $this->execute($query);
    }

    function add($data)
    {
        $nama = $data['nama'];
        $judul_buku = $data['judul_buku'];

        $query = "insert into peminjaman values ('', '$nama', '$judul_buku', 'Dalam Peminjaman')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM peminjaman WHERE id_peminjaman = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }
    
    function updateStatus($id){
        $status = "Sudah Dikembalikan";
        $query = "update peminjaman set status = '$status' where id_peminjaman = '$id'";
        
        // Mengeksekusi query
        return $this->execute($query);
    }
}


?>