-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Agu 2021 pada 14.35
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengadaan2021`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `token` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `nama`, `email`, `alamat`, `password`, `status`, `token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@mail.com', 'Jl Alamat', 'eyJpdiI6InM4Wk1XRFwvNXo3QjhsN3VocUpwN2tnPT0iLCJ2YWx1ZSI6IkllSHA2OGI3bXNxTlQrdVVtbDl3UFE9PSIsIm1hYyI6IjY2YmZmNjZiN2YyNTRjM2JjMWFkZWQzM2M2ZjNjM2JiMTIyMjA5Mjc3ZmRiM2E0ZDgwNDBlZDU4NmMzZDE2ZDEifQ==', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZF9hZG1pbiI6MX0.7cVqFDHdaBICMWarTcVU1IGJ12NFViE9Hyl4pS21e8M', '2021-08-01 20:59:47', '2021-08-18 23:07:33'),
(2, 'admin 2', 'admin2@mail.com', 'Karawang', 'eyJpdiI6IlJ6VnM3Z2U0aDY2T0ZPeVwvYTdTb3NRPT0iLCJ2YWx1ZSI6IjBFeEFjU1JWV0tzR1A0aUgyZCtHNGc9PSIsIm1hYyI6ImRkZTBiMDNiZGZhYmViOTM1OWQ4ZWI2MWI3MWE2NTc2MmY4NWE2YWNmZDQ2MzRlMzAyOTMwNjI4OTA0OWMyZjYifQ==', 1, 'keluar', '2021-08-03 20:32:13', '2021-08-15 19:15:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_laporan`
--

CREATE TABLE `tbl_laporan` (
  `id_laporan` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `id_suplier` int(11) NOT NULL,
  `laporan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_laporan`
--

INSERT INTO `tbl_laporan` (`id_laporan`, `id_pengajuan`, `id_suplier`, `laporan`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'public/laporan/Ib88MrrvLgURPKywE11ws89JhWZPs6h0fijggRER.pdf', '2021-08-10 06:14:21', '2021-08-10 06:14:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengadaan`
--

CREATE TABLE `tbl_pengadaan` (
  `id_pengadaan` int(11) NOT NULL,
  `nama_pengadaan` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` text NOT NULL,
  `anggaran` double NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pengadaan`
--

INSERT INTO `tbl_pengadaan` (`id_pengadaan`, `nama_pengadaan`, `deskripsi`, `gambar`, `anggaran`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Cator', 'http://libprint.trisakti.ac.id/id/eprint/4/2/2%20Woro%20Asty%20Werdina.pdf', 'public/gambar/x82okqvA9J2korL0m88HkJIPnUW5ZSXmjCXmfHZd.png', 45000000, 1, '2021-08-04 20:16:01', '2021-08-10 17:38:41'),
(2, 'Lemari', 'http://kms.ipb.ac.id/921/1/proposal-pengadaan-barang.pdf', 'public/gambar/umxd4ZJQRxariMolPy76foWHVclKVYJEzVQUAB7U.jpg', 3000000, 1, '2021-08-04 21:05:35', '2021-08-09 06:49:26'),
(5, 'Meja-Kursi', 'http://libprint.trisakti.ac.id/id/eprint/4/2/2%20Woro%20Asty%20Werdina.pdf', 'public/gambar/iVmartPpmqNjUpXprlzXVooSxfBUZpMh5ZxcPRcg.jpg', 5500000, 1, '2021-08-09 01:06:25', '2021-08-09 06:49:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengajuan`
--

CREATE TABLE `tbl_pengajuan` (
  `id_pengajuan` int(11) NOT NULL,
  `id_suplier` int(11) NOT NULL,
  `id_pengadaan` int(11) NOT NULL,
  `anggaran` double NOT NULL,
  `proposal` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pengajuan`
--

INSERT INTO `tbl_pengajuan` (`id_pengajuan`, `id_suplier`, `id_pengadaan`, `anggaran`, `proposal`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 40000000, 'public/proposal/zR4DRtrhZd86QlRIfdOB398dNdtmVN62M5RAswuU.pdf', 3, '2021-08-09 11:00:46', '2021-08-11 23:09:46'),
(2, 2, 2, 3000000, 'public/proposal/hQb9a21fzKqFVP31Kt5nPfWScl1H9ny3Ik393hCm.pdf', 2, '2021-08-10 02:52:43', '2021-08-10 18:13:45'),
(3, 2, 5, 5500000, 'public/proposal/AxQvrsB1e40WEJf1sxItUSJqLkmDcwPH5KAmxkTQ.pdf', 2, '2021-08-15 19:18:34', '2021-08-15 19:19:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_suplier`
--

CREATE TABLE `tbl_suplier` (
  `id_suplier` int(11) NOT NULL,
  `nama_usaha` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_npwp` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `token` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_suplier`
--

INSERT INTO `tbl_suplier` (`id_suplier`, `nama_usaha`, `email`, `alamat`, `no_npwp`, `password`, `status`, `token`, `created_at`, `updated_at`) VALUES
(1, 'PT Maju Mundur', 'majumundur@gmail.com', 'jl pt maju mundur', '1234567', 'eyJpdiI6Ild2UWNcL1B0eFFZZTh1UWtqVXhsbnNnPT0iLCJ2YWx1ZSI6IjNVNCs0ZUt2c1hRUU8zZ1pwbnVvemc9PSIsIm1hYyI6IjA3MWYyN2Q2YzgxMDI1ZjVlMDRjYTg3Yzk2MDhhZGQ4NGI2Y2E0NDVlOWNlMGYxOTM2NTJkN2U3NTA3MDQwNTQifQ==', 1, 'keluar', '2021-08-19 03:21:09', '2021-08-18 20:21:09'),
(2, 'PT Maju', 'maju@gmail.com', 'jl jalan', '12345', 'eyJpdiI6InE0aDdCK1ZMUTQ3TG16MUhNU2ZoM2c9PSIsInZhbHVlIjoiNGl4V2FpYTdCQzUrV2dPYVh6MDFDdz09IiwibWFjIjoiZWJkOWVhY2ZiMGI1NjEyMGY3YjA5YzUxMDIwN2NiODc1MDk5ODQ0OGExNGExOTY3MjQ1M2IzZWY5YzRkZTIwYSJ9', 1, 'keluar', '2021-08-19 04:47:44', '2021-08-18 21:47:44');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `tbl_laporan`
--
ALTER TABLE `tbl_laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indeks untuk tabel `tbl_pengadaan`
--
ALTER TABLE `tbl_pengadaan`
  ADD PRIMARY KEY (`id_pengadaan`);

--
-- Indeks untuk tabel `tbl_pengajuan`
--
ALTER TABLE `tbl_pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`);

--
-- Indeks untuk tabel `tbl_suplier`
--
ALTER TABLE `tbl_suplier`
  ADD PRIMARY KEY (`id_suplier`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_laporan`
--
ALTER TABLE `tbl_laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengadaan`
--
ALTER TABLE `tbl_pengadaan`
  MODIFY `id_pengadaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengajuan`
--
ALTER TABLE `tbl_pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_suplier`
--
ALTER TABLE `tbl_suplier`
  MODIFY `id_suplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
