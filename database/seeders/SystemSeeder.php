<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        System::firstOrCreate([
            'key' => 'about_1',
        ], [
            'value' => '{"title":"Apa itu QAC?","content":"QAC adalah singkatan dari Qur\'anic Arabic Course."}',
            'is_array' => true,
        ]);

        System::firstOrCreate([
            'key' => 'about_2',
        ], [
            'value' => '{"title":"Apa saja kelas di QAC?","content":"terdiri dari 3 level: level 1 QAC 1.0, level 2 QAC 2.1, level 2 QAC 2.2"}',
            'is_array' => true,
        ]);

        System::firstOrCreate([
            'key' => 'whatsapp',
        ], [
            'value' => '62895423485054',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'waitinglist',
        ], [
            'value' => 0,
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'popup_image',
        ], [
            'value' => '',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'popup_active',
        ], [
            'value' => 0,
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'why1',
        ], [
            'value' => 'Kenapa perlu belajar Bahasa Arab?',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'why2',
        ], [
            'value' => 'Kenapa belajar Bahasa Arab di QAC?',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'whatsapp_ecourse',
        ], [
            'value' => '62811111111',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'subscription_fee',
        ], [
            'value' => '30000',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'ecource_access_month',
        ], [
            'value' => '1',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'qac_1_lite_1a',
        ], [
            'value' => '',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'qac_1_lite_1b',
        ], [
            'value' => '',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'qac_1',
        ], [
            'value' => '',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'qac_2',
        ], [
            'value' => '',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'qac_3',
        ], [
            'value' => '',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'inactive_days',
        ], [
            'value' => '3',
            'is_array' => false,
        ]);

        System::firstOrCreate([
            'key' => 'faq',
        ], [
            'value' => '# QAC

## Kenapa sih harus belajar bahasa Arab ?

Al-Qur\'an adalah **surat cinta Allah kepada manusia**, agar manusia tidak tersesat di dunia dan menuju akhirat. Sebagai bentuk **balasan kasih sayangNya** maka kitapun hendaknya berusaha **memahami Al-Qur\'an** itu.

Ada perumpamaan, kalau kita berada di suatu planet, dimana agar bisa hidup baik di planet tersebut, satu-satunya jalan kita harus melihat suatu buku panduan, tetapi buku panduan tersebut dalam bahasa Rusia, kalau tidak kita bisa tidak selamat di planet tersebut. Maka belajar bahasa Rusia menjadi keharusan. Begitu pula selama kita hidup di bumi, **satu-satunya buku panduan agar bisa hidup selamat adalah Al-Qur\'an dan ini dalam bahasa Arab**. Bagaimana kita bisa selamat dan hidup baik di bumi, satu-satunya jalan adalah **belajar bahasa Arab Al-Qur\'an**.

Oleh karena itu, kita sebagai muslim, hendaknya kita membacanya untuk mendapat petunjuk darinya. Caranya yaitu dengan **berusaha memahaminya**. Untuk memahami Al-Qur\'an **secara utuh, pemahaman akan bahasa Arab Al-Qur\'an diperlukan**. Oleh karena itu, QAC mengajak para muslim untuk mulai belajar bahasa Arab Al-Qur\'an dalam rangka **makin mendekat ke Al-Qur\'an, menuju pemahaman dan menggapai petunjukNya**.

Untuk makin memahami kenapa perlu belajar bahasa Arab, bisa juga dilihat di link berikut : [https://qacjakarta.id#why1](https://qacjakarta.id#why1)

## Apa sih QAC itu ?

**QAC** adalah singkatan dari *Quranic Arabic Course*, yaitu kursus bahasa Arab khusus Al-Qur\'an dengan tujuan untuk **makin mendekatkan diri selangkah kepada Al-Qur\'an serta berorientasi tadabbur Al-Qur\'an**. Bila di sosial media **IG @QACJakarta, FB Quranic Arabic Course atau web : qacjakarta.id**

## Bagaimana kursus bahasa Arab di QAC?

**1. QAC khusus fokus pada Bahasa Arab Al-Qur\'an**

Waktu lebih cepat karena **spesifik** pada Bahasa Arab Al-Qur\'an.

**2. QAC bukan belajar bahasa Arab Al-Qur\'an biasa**

Didalam kursusnya, QAC berusaha **menyelipkan berbagai macam value** untuk mengajak menjadi muslim yang lebih baik seperti tepat waktu, profesional, kemandirian, mindfulness. Dan merupakan **sarana untuk orang-orang sefrekuensi** yang ingin makin dekat ke Al-Qur\'an, suasananya **kekeluargaan**, sehingga **tidak seperti sedang belajar formal**.

**3. Cara belajar sudah teruji**

QAC offline sudah berdiri sejak 3 tahun yang lalu, dan sudah mencapai 27 batch. Peserta QAC ada yang usianya remaja dan sd 70an tahun. Saat ini alumni sudah mencapai 600an orang, tersebar di Indonesia dan luar negeri.

**4. Pengajar mendalami Bahasa Arab & keindahan Al Qur\'an sehingga terinspirasi untuk memperkenalkannya kepada sesama muslim**

**5. QAC memudahkan untuk pemula sekalipun**

Karena memakai Bahasa pengantar Bahasa Indonesia dan tidak terlalu banyak hafalan. 90% peserta QAC adalah orang yang tidak memiliki dasar bahasa Arab sebelumnya. Cara belajarnya juga mengasyikkan, interaktif, efisien.

**6. QAC meng-empower pesertanya**

Karena setiap muslim mempunyai hak untuk mengakses Al-Qur\'an, QAC berusaha mendorong pesertanya **bisa mandiri di kemudian hari**, dalam memaknai secara global Bahasa Arab Al-Qur\'an serta mendorong melakukan tadabbur personal.

**7. QAC berorientasi tadabbur mendalam**

Tadabbur adalah yang dianjurkan oleh Al-Qur\'an di QS Shad 38 : 29, agar kita semua manusia memahami secara utuh apa maksud Allah, dan mendapatkan hikmah dan mulai mengamalkannya.

## Siapa saja peserta QAC ?

1. Secara umum, pesertanya adalah **semua orang** yang ingin makin dekat dengan Al-Qur\'an sebagai petunjuk hidupnya **(Qur\'an Seeker, Truth Seeker)**

2. Semua orang yang ingin belajar Bahasa Arab dan memahami Al-Qur\'an melalui tata bahasanya, yang **tidak bisa mengikuti kelas offline karena keterbatasan waktu dan lokasi**

## Kalau ingin tahu QAC lebih jauh, bisa kemana ?

Bisa follow **IG @QACJakarta** atau **FB Quranic Arabic Course** atau **web : qacjakarta.id**, di laman tersebut banyak **informasi seputar** :

- **a. Program**
- **b. Kapan pendaftaran**
- **c. Apa itu QAC**
- **d. Sharing dari beberapa orang alumni yang sudah melalui program QAC 1.0, QAC 2.0 (QAC 2.1 dan QAC 2.2) serta QAC 3.0**

Atau mau berinteraksi lebih lanjut bisa **DM admin IG, atau admin WA, [687743281254](https://wa.me/687743281254)**.

# PROGRAM-PROGRAM QAC

## Bagaimana cara ikutan kursus QAC ?

Caranya mendaftar dengan **mengisi form pendaftaran di web [qacjakarta.id](https://qacjakarta.id)**

## Adakah yang tidak berbayar ?

Ada, QAC **rutin tiap ahad** jam 8 WIB malam ada program **Ngobrolin Qur\'an**, program tadabbur Al-Qur\'an per ruku\' (per \'ain) bertujuan agar muslim membiasakan diri kembali ke Al-Qur\'an minimal setiap pekan dan ini **FREE**, bisa mendaftar langsung dengan isi formulir di **bit.ly/ngobrolinquranQAC**. Selain itu QAC juga sering melakukan acara **free sharing** semua terkait Al-Qur\'an, itu biasanya diinformasikan di **IG @QACJakarta**.

## Level QAC apa saja ? dan apa beda masing-masing ?

Levelnya yang sudah ada di QAC :

1. **LEVEL DASAR, basic nahwu**. Program ini untuk level pemula yang belum pernah belajar bahasa Arab Al-Qur\'an sebelumnya. Di level ini, peserta mempelajari hubungan antar kata secara keseluruhan, sebagai dasar tata bahasa Arab Al-Qur\'an, dan peserta dibiasakan untuk melakukan tadabbur. Level dasar terbagi menjadi 2 program :

            i. **QAC 1.0 ONLINE** : dilakukan selama **16 hari berturut-turut secara LIVE**, materinya detail, dan setelah selesai akan **difasilitasi dengan grup keluarga alumni dengan setiap hari dilatih praktek implementasi materi dan tadabbur** 
            ii. **SELF PACE QAC 1.0 LITE** : materi sama seperti QAC 1.0 online tetapi dalam versi **lebih ringkas tapi tidak mengurangi esensinya**. Dan diperuntukan bagi mereka yang **sangat sibuk, sulit waktu belajarnya, atau belajarnya pelan dan yang butuh investasi terbatas**. Program ini bisa **menyesuaikan pace belajar peserta dengan fleksibel.**

**2. LEVEL LANJUTAN :**

            i. **QAC 2.0, basic sharf**. Di level ini, peserta mempelajari 1 kata secara mendalam dengan berbagai macam bentuknya menjadi ratusan jenis kata, merupakan bagian dasar dan bentuk **standar dari morfologi bahasa Arab Al-Qur\'an**. Peserta dilatih untuk mampu mengurai makna mendalam tiap kata, dan kenapa Allah berfirman dengan kata tersebut.
            ii. **QAC 3.0, advance nahwu**, membahas berbagai macam bentuk **tidak standar (abnormal)** dari tata bahasa dan morfologi bahasa Arab Al-Qur\'an. Peserta dilatih untuk mampu mendalami makna tersirat dari firman Allah, sehingga memahami ekspresi yang Allah ingin sampaikan.

## Tujuan saya mengikuti belajar di QAC level dasar (QAC 1.0) ?

1. Peserta **mampu membangun fondasi yang kuat** pada prinsip-prinsip Bahasa Arab melalui contoh-contoh yang diambil langsung dari Al-Qur\'an

2. Peserta mengerti **cara menggunakan kata-kata yang sering digunakan** dalam Al-Qur\'an dan mampu menghafalkan beserta artinya

3. Peserta mampu **mengetahui gambaran besar tata Bahasa Arab Al-Qur\'an** sehingga peserta akan mampu **membangun hubungan baik dengan Al-Qur\'an**

## Apa syarat mengikuti program QAC level dasar (QAC 1.0) ?

1. **Minimal SMP**

2. Mampu membaca Al-Qur\'an **minimal** setara **iqra\' 4**

3. Mempunyai **fasilitas online** (HP /tablet / laptop) dan **internet dengan sinyal bagus**

4. Akan lebih baik bila mampu Bahasa Inggris, tetapi tidak harus

5. **Tidak harus** mampu menulis Bahasa Arab

6. **Tidak perlu** kemampuan Bahasa Arab, belum pernah belajar dipersilahkan

7. **Kemauan sendiri, tidak dipaksa oleh orang lain**

## Apakah QAC, ada kelas offline ?

Untuk saat ini QAC belum ada kelas offline, dikarenakan pandemi dan agar dapat menjangkau para Qur\'an seeker di Indonesia.

## Apakah saya yang berada di luar negeri bisa ikutan program QAC ?

**Sangat Bisa**, karena insya Allah semua materi sudah disediakan di web, tinggal download saja.

## Bagaimana metode & kurikulum QAC ? dan siapa pengajarnya ?

Metodenya memudahkan peserta walaupun belum pernah belajar bahasa Arab sekalipun, kurikulumnya adalah kurikulum QAC, pengajarnya sudah belajar bahasa Arab sejak tahun 2000. Alumni QAC sudah sekitar 1500 orang dari seluruh Indonesia dan luar Indonesia.

# ALUMNI QAC

## Kenapa ada Alumni QAC?

Karena :
        a. Visi QAC adalah ingin mengajak muslim kembali ke Al-Qur\'an **tidak hanya membaca tapi juga merenunginya dengan tadabbur** sehingga akhirnya mendorong ke **pengamalan**. Maka acara alumni QAC dilakukan **hampir tiap hari** untuk **pembiasaan** dengan **memulai hari** dengan Al-Qur\'an. 
        b. Selain itu, di keluarga Alumni QAC diperbolehkan untuk bisa **tanya jawab materi** yang telah didapat, atau ada menemukan ayat yang perlu dibahas, ditadabburi.
        c. Fasilitas Alumni QAC ini yang **sangat berharga**, mengajak tadabbur Qur\'annya bareng-bareng, harapannya akan **menularkan** kepada keluuarga dan kerabat terdekat

## Apa fasilitas Alumni QAC ?

Setiap alumni QAC dapat mengakses acara Alumni QAC hampir tiap hari **secara LIVE**, dari cara implementasi materi yang didapat sampai ke tadabbur per ruku\' serta tadabbur secara tematik. Untuk detail acaranya ada di IG @qacjakarta. Dan baru hanya Alumni QAC yang **bisa akses kembali semua acara alumni melalui video rekaman melalui web qacjakarta.id** dengan berlangganan Rp. 1000/hari sebagai bentuk dukungan dakwah pembiasaan tadabbur Al-Qur\'an dan memenuhi biaya operasional server.',
            'is_array' => false,
        ]);
    }
}
