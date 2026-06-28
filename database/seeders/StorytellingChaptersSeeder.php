<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorytellingChaptersSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('storytelling_chapters')->count() > 0) {
            return;
        }

        DB::table('storytelling_chapters')->insert([
            [
                'chapter_key' => 'bab_2',
                'title' => 'Fungsi, Teknik, & Pengetahuan Tangan',
                'content' => json_encode([
                    'main_desc' => 'Tanah liat sawah dicampur pasir halus sawah dicampur pasir halus sungai dibentuk dengan teknik tradisional paddle anvil (tatap pelandas), handwheel (putar kaki/tangan), hingga dibakar secara terbuka (open firing). Klik kategori di bawah untuk mengeksplorasi nilainya.',
                    'fungsional_text' => 'Meliputi pendil, paso, kuali, kendi, gentong air, buyung, dan pedaringan yang dekat dengan kehidupan dapur dan sumur warga. Kendi berfungsi sebagai teknologi pendingin alami. Gentong dan pedaringan menyimbolkan penyimpanan, ketahanan pangan, dan kesiapan rumah tangga yang bersahaja dengan alam.',
                    'religi_text' => 'Diwakili oleh Memolo (mastaka/hiasan pucuk atap kubah masjid kuno Cirebon) dan Padasan (gentong tanah liat berlubang pancuran untuk berwudu). Air wudu yang keluar dari padasan tanah melambangkan kesucian lahir-batin dan pengingat bahwa manusia diciptakan dari unsur tanah yang bersahaja.',
                    'simbolik_text' => 'Perwujudan makhluk mitologis Cirebonan yang dibentuk menjadi patung tanah liat terakota, seperti Paksinagaliman, Macan Ali, Singabarong, Burok, Jatayu, Garuda Mungkur, dan Gajah Mungkur. Awalnya dibentuk sebagai pernyataan kekuatan, perlindungan, dan penyatuan unsur-unsur kekuasaan tradisional.',
                    'estetis_text' => 'Meliputi vas bunga kontemporer, pot tanaman, jambangan air hias, dan topeng dinding dekoratif. Kategori ini menyatukan tradisi turun-temurun pengolahan tanah liat lokal dengan inovasi interior modern, menjadi jembatan ekonomi kreatif yang relevan dengan selera pasar modern tanpa menghapus identitas asalnya.',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chapter_key' => 'bab_3',
                'title' => 'Filosofi Ragam Motif',
                'content' => json_encode([
                    'main_desc' => 'Ragam hias Sitiwinangun menjadi pembeda visual utama dari sentra lainnya. Setiap goresan adalah cara masyarakat menitipkan doa dan cerita pada tanah.',
                    'motif_1_title' => 'Megamendung',
                    'motif_1_desc' => 'Awan horizontal lambang dunia atas dan kesuburan yang lahir dari akulturasi pesisir Cirebon dengan budaya Cina. Menyimpan filosofi harapan yang luas, kejernihan pikiran, dan kelenturan kultural menyerap pengaruh luar tanpa tercerabut dari akar tanah sendiri.',
                    'motif_2_title' => 'Wadasan (Batu Karang)',
                    'motif_2_desc' => 'Bentuk runcing vertikal menyerupai batu cadas yang melambangkan dunia bawah dan kekuatan bumi. Diartikan sebagai pondasi kehidupan yang kokoh, keteguhan hati masyarakat, serta kekuatan iman dan akidah spiritual yang tegap tidak tergoyahkan.',
                    'motif_3_title' => 'Melaten (Melati)',
                    'motif_3_desc' => 'Motif bunga melati mekar melambangkan kehalusan, keharuman nama, kesucian, dan ketulusan niat. Mengandung pesan luhur bahwa material tanah yang kasar pun sanggup memikul and memperlihatkan simbol kesucian jiwa manusia.',
                    'motif_4_title' => 'Kembang & Sulur Kangkung',
                    'motif_4_desc' => 'Motif dedaunan liar menjalar yang tumbuh subur di sekitar perairan desa. Merepresentasikan kedekatan dengan ekologi pedesaan, pertumbuhan, serta ketahanan dan daya lentur (adaptasi) warga Sitiwinangun dalam merambat menghadapi cobaan hidup.',
                    'motif_5_title' => 'Lingkaran Memusat',
                    'motif_5_desc' => 'Ornamen torehan lingkaran konsentris melambangkan keseimbangan hidup komunal dan pola kebersamaan desa. Mengingatkan warga bahwa sejauh mana pun mereka melangkah, hidup bermuara pada satu pusat yaitu tanah asal, keluarga, dan persaudaraan.',
                    'motif_6_title' => 'Ragam Hias Lainnya',
                    'motif_6_desc' => 'Masih banyak motif ornamen lokal seperti Tepen, Rumbing, Untu Walang, Berundakan, Kawung, Bulan Sabit, dan Kaligrafi yang menyusun khazanah estetika organik khas budaya agraris-religius pesisir utara Jawa Barat.',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chapter_key' => 'bab_4',
                'title' => 'Mitologi Cirebon',
                'content' => json_encode([
                    'main_desc' => 'Bentuk-bentuk mitologi Cirebon yang diwujudkan dalam wujud patung terakota gerabah, menjadi simbol kerukunan akulturasi budaya.',
                    'paksi_text' => 'Visual hibrid legendaris yang menggabungkan tiga unsur: Paksi (burung/Garuda lambang udara & Nusantara), Naga (ular naga lambang lautan & Cina), serta Liman (gajah lambang daratan/tanah & India). Penggabungan ketiganya menjadi perlambangan kekuatan kosmologis triloka (dunia atas, tengah, bawah) sekaligus saksi bisu bahwa peradaban Cirebon tumbuh harmonis dari perjumpaan damai berbagai bangsa secara etis.',
                    'paksi_card_desc' => 'Burung (langit/Nusantara), naga (laut/Cina), dan gajah (darat/India) menyatu dalam satu visual kosmologi Cirebon yang megah.',
                    'macan_text' => 'Terinspirasi dari keperkasaan Sayidina Ali dan kaligrafi kalimat tauhid Islam yang membentuk tubuh macan dalam bendera Kesultanan Cirebon. Menyimpan pesan keberanian dan perlindungan spiritual yang bersandar pada ketakwaan.',
                    'macan_card_desc' => 'Lambang perlindungan, kepahlawanan, dan keberanian masyarakat Cirebon yang bertumpu pada ketakwaan spiritual.',
                    'singabarong_text' => 'Singabarong melambangkan kemegahan wibawa kekuasaan, sementara Burok dikaitkan erat dengan kisah Isra Mi\'raj nabi. Kehadirannya dalam bentuk gerabah memperlihatkan media syiar agama Islam yang menyatu lembut dengan imajinasi kesenian rakyat setempat.',
                    'singabarong_card_desc' => 'Singabarong sebagai lambang kewibawaan tahta kerajaan, dan Burok sebagai pengantar dakwah kultural Islam di pesisir.',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chapter_key' => 'bab_5',
                'title' => 'Kearifan Lokal',
                'content' => json_encode([
                    'main_desc' => 'Dua tutur kearifan lokal ekonomi moral yang menjadi jaring pengaman sosial warga Desa Sitiwinangun.',
                    'tutur_1_title' => 'Sugih Ora Rerawat',
                    'tutur_1_desc' => 'Artinya: sekaya-kayanya orang Sitiwinangun, hartanya tidak melulu disimpan dalam emas atau kemewahan mencolok yang harus dijaga ketat. Kekayaan mereka disimpan dalam penguasaan keterampilan kriya, tanah liat, dan jalinan persaudaraan.',
                    'tutur_1_subtext' => 'Nilai luhur ini mengajarkan bahwa kekayaan sejati adalah pengetahuan tangan dan jejaring sosial yang produktif—harta hidup yang tidak akan pernah bisa dicuri oleh orang lain.',
                    'tutur_2_title' => 'Melarat Ora Gegulat',
                    'tutur_2_desc' => 'Artinya: semiskin-miskinnya orang Sitiwinangun, mereka tidak harus terusir pergi dari kampung halaman untuk sekadar mencari suap nasi. Ketika seorang pengrajin sepi pesanan, tetangga atau saudaranya akan merangkul mereka.',
                    'tutur_2_subtext' => 'Jejaring komunal bertindak sebagai jaring pengaman ekonomi. Warga saling berbagi tahapan order (misal membantu menjemur, menghias, atau membakar gerabah) agar semua orang tetap memperoleh upah dan hidup layak bersama.',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
