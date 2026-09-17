# SRS — JARA, an Advanced Todo List

## User Requirement

JARA adalah aplikasi web untuk mengelola tugas pribadi maupun tim. Pengguna dapat membuat, mengelompokkan, dan mengatur tugas ke dalam beberapa daftar (list/project), menetapkan prioritas dan tenggat waktu, serta menandai tugas sebagai selesai.

Pemilik daftar dapat menambahkan pengguna lain ke dalam daftar tugasnya agar dapat dikerjakan bersama, dan memantau progres penyelesaian tugas dalam daftar tersebut.

Admin bertanggung jawab menambah dan menghapus akun pengguna dalam sistem.

## Daftar SRS

| Kode SRS | Deskripsi | Kriteria |
|---|---|---|
| SRS-01 | **Manajemen Akun** — Pengguna dapat melakukan login dan menggunakan akun untuk mengakses sistem. | Pengguna dapat login dengan akun yang terdaftar dan masuk ke halaman utama. |
| SRS-02 | **Manajemen List/Project** — Pengguna dapat membuat, melihat, mengubah, dan menghapus daftar tugas (list/project). | User dapat melakukan Create, Read, Update, Delete list/project miliknya sendiri. |
| SRS-03 | **Manajemen Tugas** — Pengguna dapat membuat, melihat, mengubah, dan menghapus tugas dalam suatu list/project. | User dapat melakukan Create, Read, Update, Delete tugas pada list yang dimilikinya. |
| SRS-04 | **Prioritas & Tenggat Waktu** — Pengguna dapat memberikan prioritas dan deadline pada tugas. | Setiap tugas dapat memiliki prioritas dan tanggal tenggat yang dapat diubah. |
| SRS-05 | **Status Penyelesaian** — Pengguna dapat menandai tugas sebagai selesai dan melihat status penyelesaiannya. | Status tugas dapat diubah menjadi selesai/belum selesai. |
| SRS-06 | **Kolaborasi List** — Pemilik list dapat menambahkan pengguna lain ke dalam list tugas untuk bekerja bersama. | Owner dapat menambahkan user ke list dan user tersebut dapat mengakses tugas dalam list. |
| SRS-07 | **Monitoring Progress** — Pengguna dapat melihat perkembangan penyelesaian tugas dalam suatu list. | Sistem menampilkan jumlah/progres tugas selesai dibandingkan seluruh tugas. |
| SRS-08 | **Manajemen User oleh Admin** — Admin dapat menambah dan menghapus akun pengguna. | Admin dapat membuat akun user baru dan menghapus akun yang terdaftar. |
| SRS-09 | **Kepemilikan List Otomatis** — Pengguna yang membuat daftar tugas baru akan secara otomatis menjadi pemilik (owner) daftar tersebut. | Sistem secara otomatis menetapkan status owner kepada pembuat list saat proses create berhasil |
| SRS-10 | **Penghapusan List Menyeluruh** — Pengguna dapat menghapus daftar yang dimilikinya beserta seluruh tugas dan keanggotaan di dalamnya. | Saat owner menghapus list, data list, seluruh tugas (task), dan data kolaborator di dalamnya ikut terhapus seluruhnya. |

