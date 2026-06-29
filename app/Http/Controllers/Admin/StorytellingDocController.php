<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StorytellingChapter;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class StorytellingDocController extends Controller
{
    protected ActivityLogService $logger;

    public function __construct(ActivityLogService $logger)
    {
        $this->logger = $logger;
    }

    public function index(Request $request)
    {
        $bab2 = StorytellingChapter::firstOrCreate(['chapter_key' => 'bab_2'], [
            'title' => 'Fungsi, Teknik, & Pengetahuan Tangan',
            'content' => [
                'main_desc' => 'Tanah liat sawah dicampur pasir halus sungai dibentuk dengan teknik tradisional paddle anvil (tatap pelandas), handwheel (putar kaki/tangan), hingga dibakar secara terbuka (open firing). Klik kategori di bawah untuk mengeksplorasi nilainya.',
                'fungsional_text' => 'Meliputi pendil, paso, kuali, kendi, gentong air, buyung, dan pedaringan yang dekat dengan kehidupan dapur dan sumur warga. Kendi berfungsi sebagai teknologi pendingin alami. Gentong dan pedaringan menyimbolkan penyimpanan, ketahanan pangan, dan kesiapan rumah tangga yang bersahaja dengan alam.',
                'religi_text' => 'Diwakili oleh Memolo (mastaka/hiasan pucuk atap kubah masjid kuno Cirebon) dan Padasan (gentong tanah liat berlubang pancuran untuk berwudu). Air wudu yang keluar dari padasan tanah melambangkan kesucian lahir-batin dan pengingat bahwa manusia diciptakan dari unsur tanah yang bersahaja.',
                'simbolik_text' => 'Perwujudan makhluk mitologis Cirebonan yang dibentuk menjadi patung tanah liat terakota, seperti Paksinagaliman, Macan Ali, Singabarong, Burok, Jatayu, Garuda Mungkur, dan Gajah Mungkur. Awalnya dibentuk sebagai pernyataan kekuatan, perlindungan, dan penyatuan unsur-unsur kekuasaan tradisional.',
                'estetis_text' => 'Meliputi vas bunga kontemporer, pot tanaman, jambangan air hias, dan topeng dinding dekoratif. Kategori ini menyatukan tradisi turun-temurun pengolahan tanah liat lokal dengan inovasi interior modern, menjadi jembatan ekonomi kreatif yang relevan dengan selera pasar modern tanpa menghapus identitas asalnya.',
            ]
        ]);

        $bab3 = StorytellingChapter::firstOrCreate(['chapter_key' => 'bab_3'], [
            'title' => 'Filosofi Ragam Motif',
            'content' => [
                'main_desc' => 'Ragam hias Sitiwinangun menjadi pembeda visual utama dari sentra lainnya. Setiap goresan adalah cara masyarakat menitipkan doa dan cerita pada tanah.',
                'motif_1_title' => 'Motif Wadasan',
                'motif_1_desc' => 'Melambangkan fondasi kehidupan yang kokoh, keteguhan hati, dan kekuatan spiritual masyarakat menghadapi gelombang perubahan zaman.',
                'motif_2_title' => 'Motif Mega Mendung',
                'motif_2_desc' => 'Awan pembawa hujan lambang kesuburan, kemakmuran, kepemimpinan yang mengayomi, serta ketenangan emosi yang harus dijaga.',
                'motif_3_title' => 'Motif Patran',
                'motif_3_desc' => 'Liku sulur tumbuhan organik menjalar lambang kelangsungan hidup yang harmonis, pertumbuhan komunal, dan adaptabilitas tanpa batas.',
                'motif_4_title' => 'Motif Pecahan Piring Cina',
                'motif_4_desc' => 'Bukti sejarah kuat perdagangan maritim dan kerukunan asimilasi budaya keramik Tiongkok dengan kehangatan terakota lokal.',
                'motif_5_title' => 'Motif Flora & Fauna',
                'motif_5_desc' => 'Representasi ragam kehidupan alami Cirebon, mengabadikan keindahan hayati pesisir dan hubungan bersahaja manusia dengan alam.',
                'motif_6_title' => 'Ragam Hias Lainnya',
                'motif_6_desc' => 'Masih banyak motif ornamen lokal seperti Tepen, Rumbing, Untu Walang, Berundakan, Kawung, Bulan Sabit, dan Kaligrafi yang menyusun khazanah estetika organik khas budaya agraris-religius pesisir utara Jawa Barat.',
            ]
        ]);

        $bab4 = StorytellingChapter::firstOrCreate(['chapter_key' => 'bab_4'], [
            'title' => 'Mitologi Cirebon',
            'content' => [
                'main_desc' => 'Bentuk-bentuk mitologi Cirebon yang diwujudkan dalam wujud patung terakota gerabah, menjadi simbol kerukunan akulturasi budaya.',
                'paksi_text' => 'Visual hibrid legendaris yang menggabungkan tiga unsur: Paksi (burung/Garuda lambang udara & Nusantara), Naga (ular naga lambang lautan & Cina), serta Liman (gajah lambang daratan/tanah & India). Penggabungan ketiganya menjadi perlambangan kekuatan kosmologis triloka (dunia atas, tengah, bawah) sekaligus saksi bisu bahwa peradaban Cirebon tumbuh harmonis dari perjumpaan damai berbagai bangsa secara etis.',
                'macan_text' => 'Terinspirasi dari keperkasaan Sayidina Ali dan kaligrafi kalimat tauhid Islam yang membentuk tubuh macan dalam bendera Kesultanan Cirebon. Menyimpan pesan keberanian dan perlindungan spiritual yang bersandar pada ketakwaan.',
                'singabarong_text' => 'Singabarong melambangkan kemegahan wibawa kekuasaan, sementara Burok dikaitkan erat dengan kisah Isra Mi\'raj nabi. Kehadirannya dalam bentuk gerabah memperlihatkan media syiar agama Islam yang menyatu lembut dengan imajinasi kesenian rakyat setempat.',
                'paksi_card_desc' => 'Burung (langit/Nusantara), naga (laut/Cina), dan gajah (darat/India) menyatu dalam satu visual kosmologi Cirebon yang megah.',
                'macan_card_desc' => 'Lambang perlindungan, kepahlawanan, dan keberanian masyarakat Cirebon yang bertumpu pada ketakwaan spiritual.',
                'singabarong_card_desc' => 'Singabarong sebagai lambang kewibawaan tahta kerajaan, dan Burok sebagai pengantar dakwah kultural Islam di pesisir.',
            ]
        ]);

        $bab5 = StorytellingChapter::firstOrCreate(['chapter_key' => 'bab_5'], [
            'title' => 'Kearifan Lokal',
            'content' => [
                'main_desc' => 'Dua tutur kearifan lokal ekonomi moral yang menjadi jaring pengaman sosial warga Desa Sitiwinangun.',
                'tutur_1_title' => 'Sugih Ora Rerawat',
                'tutur_1_desc' => 'Artinya: sekaya-kayanya orang Sitiwinangun, hartanya tidak melulu disimpan dalam emas atau kemewahan mencolok yang harus dijaga ketat. Kekayaan mereka disimpan dalam penguasaan keterampilan kriya, tanah liat, dan jalinan persaudaraan.',
                'tutur_1_subtext' => 'Nilai luhur ini mengajarkan bahwa kekayaan sejati adalah pengetahuan tangan dan jejaring sosial yang produktif—harta hidup yang tidak akan pernah bisa dicuri oleh orang lain.',
                'tutur_2_title' => 'Melarat Ora Gegulat',
                'tutur_2_desc' => 'Artinya: semiskin-miskinnya orang Sitiwinangun, mereka tidak harus terusir pergi dari kampung halaman untuk sekadar mencari suap nasi. Ketika seorang pengrajin sepi pesanan, tetangga atau saudaranya akan merangkul mereka.',
                'tutur_2_subtext' => 'Jejaring komunal bertindak sebagai jaring pengaman ekonomi. Warga saling berbagi tahapan order (misal membantu menjemur, menghias, atau membakar gerabah) agar semua orang tetap memperoleh upah dan hidup layak bersama.',
            ]
        ]);

        return view('admin.storytelling.edit_chapters', compact('bab2', 'bab3', 'bab4', 'bab5'));
    }

    public function updateChapters(Request $request)
    {
        $validated = $request->validate([
            'bab2_main_desc' => 'required|string',
            'bab2_fungsional_text' => 'required|string',
            'bab2_religi_text' => 'required|string',
            'bab2_simbolik_text' => 'required|string',
            'bab2_estetis_text' => 'required|string',

            'bab3_main_desc' => 'required|string',
            'bab3_motif_1_title' => 'required|string',
            'bab3_motif_1_desc' => 'required|string',
            'bab3_motif_2_title' => 'required|string',
            'bab3_motif_2_desc' => 'required|string',
            'bab3_motif_3_title' => 'required|string',
            'bab3_motif_3_desc' => 'required|string',
            'bab3_motif_4_title' => 'required|string',
            'bab3_motif_4_desc' => 'required|string',
            'bab3_motif_5_title' => 'required|string',
            'bab3_motif_5_desc' => 'required|string',
            'bab3_motif_6_title' => 'required|string',
            'bab3_motif_6_desc' => 'required|string',

            'bab4_main_desc' => 'required|string',
            'bab4_paksi_text' => 'required|string',
            'bab4_macan_text' => 'required|string',
            'bab4_singabarong_text' => 'required|string',
            'bab4_paksi_card_desc' => 'required|string',
            'bab4_macan_card_desc' => 'required|string',
            'bab4_singabarong_card_desc' => 'required|string',

            'bab5_main_desc' => 'required|string',
            'bab5_tutur_1_title' => 'required|string',
            'bab5_tutur_1_desc' => 'required|string',
            'bab5_tutur_1_subtext' => 'required|string',
            'bab5_tutur_2_title' => 'required|string',
            'bab5_tutur_2_desc' => 'required|string',
            'bab5_tutur_2_subtext' => 'required|string',
        ]);

        $this->updateChapterData('bab_2', [
            'main_desc' => $validated['bab2_main_desc'],
            'fungsional_text' => $validated['bab2_fungsional_text'],
            'religi_text' => $validated['bab2_religi_text'],
            'simbolik_text' => $validated['bab2_simbolik_text'],
            'estetis_text' => $validated['bab2_estetis_text'],
        ]);

        $this->updateChapterData('bab_3', [
            'main_desc' => $validated['bab3_main_desc'],
            'motif_1_title' => $validated['bab3_motif_1_title'],
            'motif_1_desc' => $validated['bab3_motif_1_desc'],
            'motif_2_title' => $validated['bab3_motif_2_title'],
            'motif_2_desc' => $validated['bab3_motif_2_desc'],
            'motif_3_title' => $validated['bab3_motif_3_title'],
            'motif_3_desc' => $validated['bab3_motif_3_desc'],
            'motif_4_title' => $validated['bab3_motif_4_title'],
            'motif_4_desc' => $validated['bab3_motif_4_desc'],
            'motif_5_title' => $validated['bab3_motif_5_title'],
            'motif_5_desc' => $validated['bab3_motif_5_desc'],
            'motif_6_title' => $validated['bab3_motif_6_title'],
            'motif_6_desc' => $validated['bab3_motif_6_desc'],
        ]);

        $this->updateChapterData('bab_4', [
            'main_desc' => $validated['bab4_main_desc'],
            'paksi_text' => $validated['bab4_paksi_text'],
            'macan_text' => $validated['bab4_macan_text'],
            'singabarong_text' => $validated['bab4_singabarong_text'],
            'paksi_card_desc' => $validated['bab4_paksi_card_desc'],
            'macan_card_desc' => $validated['bab4_macan_card_desc'],
            'singabarong_card_desc' => $validated['bab4_singabarong_card_desc'],
        ]);

        $this->updateChapterData('bab_5', [
            'main_desc' => $validated['bab5_main_desc'],
            'tutur_1_title' => $validated['bab5_tutur_1_title'],
            'tutur_1_desc' => $validated['bab5_tutur_1_desc'],
            'tutur_1_subtext' => $validated['bab5_tutur_1_subtext'],
            'tutur_2_title' => $validated['bab5_tutur_2_title'],
            'tutur_2_desc' => $validated['bab5_tutur_2_desc'],
            'tutur_2_subtext' => $validated['bab5_tutur_2_subtext'],
        ]);

        return redirect()->route('admin.storytelling.index')
            ->with('success', 'Narasi Kisah Kriya (Bab 2-5) berhasil diperbarui.');
    }

    private function updateChapterData($key, array $content)
    {
        $chapter = StorytellingChapter::where('chapter_key', $key)->first();
        if ($chapter) {
            $oldData = $chapter->toArray();
            $chapter->update(['content' => $content]);
            $this->logger->log('update_chapter', 'storytelling_chapter', $chapter->id, $oldData, $chapter->toArray());
        }
    }
}
