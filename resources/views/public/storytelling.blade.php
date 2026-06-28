@extends('layouts.public')

@section('title', 'Kisah Gerabah Sitiwinangun — Digital Storytelling')
@section('meta_description', 'Ikuti kisah naratif "Dari Tanah Menjadi Warisan" tentang filosofi tanah liat, proses kreatif pengrajin, dan sejarah gerabah Sitiwinangun.')

@section('content')

{{-- Hero Section --}}
<section class="relative bg-neutral text-neutral-content py-24 px-4 overflow-hidden bg-batik-pattern">
    <div class="absolute inset-0 bg-black/60 z-0"></div>
    <div class="max-w-4xl mx-auto text-center relative z-10 animate-fade-in-up">
        <span class="text-xs uppercase tracking-[.3em] text-primary font-bold">Digital Storytelling</span>
        <h1 class="font-serif text-4xl md:text-5xl font-bold mt-3 mb-6 text-white leading-tight">
            Dari Tanah Menjadi Warisan
        </h1>
        <p class="text-sm md:text-base text-gray-300 max-w-2xl mx-auto leading-relaxed">
            Mengenal gerabah Sitiwinangun, kriya tanah liat dari Cirebon yang tumbuh dari tangan pengrajin, tradisi keluarga, dan cerita desa yang diwariskan lintas generasi.
        </p>
    </div>
</section>

{{-- Narasi Pembuka --}}
<section class="py-16 px-4 bg-base-100">
    <div class="max-w-3xl mx-auto text-center">
        <div class="inline-flex p-3 rounded-full bg-primary/5 text-primary mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </div>
        <p class="font-serif text-lg md:text-xl text-base-content/85 italic leading-relaxed font-medium">
            "Di Desa Sitiwinangun, tanah liat tidak berhenti sebagai bahan baku. Di tangan para pengrajin, tanah dibentuk menjadi kendi, guci, pot, vas, teko, dan karya dekoratif yang menyimpan cerita tentang keluarga, kerja keras, dan warisan budaya Cirebon."
        </p>
        <div class="divider w-32 mx-auto my-8 opacity-40"></div>
        <p class="text-sm md:text-base text-base-content/70 leading-relaxed text-justify sm:text-center">
            Setiap karya lahir dari proses yang menuntut kesabaran: memilih tanah, mengolah, membentuk, mengeringkan, membakar, lalu menyelesaikan detail akhir. Tidak semua proses tampak cepat, tetapi justru di situlah letak nilainya.
        </p>
    </div>
</section>

{{-- Bab 1: Jiwa Sitiwinangun --}}
<section class="py-16 px-4 bg-base-200/50 border-y border-base-300/30">
    <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-7 space-y-4">
            <span class="text-xs uppercase tracking-wider text-accent font-bold">Bab I</span>
            <h2 class="font-serif text-2xl md:text-3xl font-bold text-primary">Jiwa &amp; Tanah Sitiwinangun</h2>
            <p class="text-sm md:text-base text-base-content/80 leading-relaxed text-justify">
                Dalam sejumlah rujukan budaya, nama <strong>Sitiwinangun</strong> dimaknai dari kata <em>siti</em> yang berarti tanah dan <em>winangun</em> yang berarti dibangun atau dibentuk. Nama ini terasa dekat dengan kehidupan masyarakatnya: tanah menjadi sumber keterampilan, mata pencaharian, dan identitas budaya.
            </p>
            <p class="text-sm md:text-base text-base-content/80 leading-relaxed text-justify">
                Tradisi membuat gerabah di Sitiwinangun memiliki sejarah panjang yang berkembang sejak abad ke-15, berkaitan erat dengan penyebaran Islam serta pengajaran keterampilan membuat gerabah di wilayah tersebut. Dalam tradisi lokal, Desa Sitiwinangun juga dikaitkan dengan Padukuhan Kebagusan, Syekh Dinureja, dan Pangeran Panjunan sebagai bagian dari memori kolektif masyarakat tentang asal-usul gerabah.
            </p>
        </div>
        <div class="lg:col-span-5 flex justify-center">
            {{-- Visual Graphic for Clay Forming --}}
            <div class="relative w-72 h-72 rounded-full bg-gradient-to-tr from-primary/10 to-accent/10 border border-primary/20 flex items-center justify-center p-6 shadow-inner">
                <div class="absolute inset-4 rounded-full border border-dashed border-primary/20 animate-spin-slow"></div>
                <div class="z-10 text-center space-y-2">
                    <span class="text-4xl">🏺</span>
                    <h4 class="font-serif font-bold text-primary">Siti Winangun</h4>
                    <p class="text-[10px] text-base-content/50 uppercase tracking-widest">Tanah yang Dibentuk</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Bab 2: Fungsi, Teknik, & Pengetahuan Tangan --}}
<section class="py-16 px-4 bg-base-100" x-data="{ activeTab: 'fungsional' }">
    <div class="max-w-4xl mx-auto text-center mb-12">
        <span class="text-xs uppercase tracking-wider text-accent font-bold">Bab II</span>
        <h2 class="font-serif text-2xl md:text-3xl font-bold text-primary mt-2">Fungsi, Teknik, &amp; Pengetahuan Tangan</h2>
        <p class="text-xs md:text-sm text-base-content/60 mt-3 max-w-xl mx-auto">
            {!! $bab2->content['main_desc'] ?? 'Tanah liat sawah dicampur pasir halus sungai dibentuk dengan teknik tradisional paddle anvil (tatap pelandas), handwheel (putar kaki/tangan), hingga dibakar secara terbuka (open firing). Klik kategori di bawah untuk mengeksplorasi nilainya.' !!}
        </p>
    </div>

    {{-- Interactive Tabs --}}
    <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
        {{-- Left: Tab selectors --}}
        <div class="md:col-span-4 flex flex-row md:flex-col gap-2 overflow-x-auto md:overflow-x-visible pb-4 md:pb-0 scrollbar-none">
            <button @click="activeTab = 'fungsional'"
                    :class="activeTab === 'fungsional' ? 'bg-primary text-primary-content font-bold' : 'bg-base-200 text-base-content/70 hover:bg-base-300/60'"
                    class="flex-1 md:flex-none text-left px-5 py-4 rounded-xl transition-all duration-200 text-xs md:text-sm font-semibold flex items-center gap-3">
                <span class="text-lg">🥣</span> Fungsional
            </button>
            <button @click="activeTab = 'religi'"
                    :class="activeTab === 'religi' ? 'bg-primary text-primary-content font-bold' : 'bg-base-200 text-base-content/70 hover:bg-base-300/60'"
                    class="flex-1 md:flex-none text-left px-5 py-4 rounded-xl transition-all duration-200 text-xs md:text-sm font-semibold flex items-center gap-3">
                <span class="text-lg">🕌</span> Religi
            </button>
            <button @click="activeTab = 'simbolik'"
                    :class="activeTab === 'simbolik' ? 'bg-primary text-primary-content font-bold' : 'bg-base-200 text-base-content/70 hover:bg-base-300/60'"
                    class="flex-1 md:flex-none text-left px-5 py-4 rounded-xl transition-all duration-200 text-xs md:text-sm font-semibold flex items-center gap-3">
                <span class="text-lg">🐉</span> Simbolik
            </button>
            <button @click="activeTab = 'estetis'"
                    :class="activeTab === 'estetis' ? 'bg-primary text-primary-content font-bold' : 'bg-base-200 text-base-content/70 hover:bg-base-300/60'"
                    class="flex-1 md:flex-none text-left px-5 py-4 rounded-xl transition-all duration-200 text-xs md:text-sm font-semibold flex items-center gap-3">
                <span class="text-lg">✨</span> Estetis &amp; Hias
            </button>
        </div>

        {{-- Right: Content Display --}}
        <div class="md:col-span-8 bg-base-200/50 p-6 md:p-8 rounded-2xl border border-base-300/30 min-h-[220px] flex items-center">
            {{-- Fungsional --}}
            <div x-show="activeTab === 'fungsional'" x-transition class="space-y-4">
                <h3 class="font-serif text-xl font-bold text-primary flex items-center gap-2">
                    <span>🥣</span> Kriya Fungsional
                </h3>
                <p class="text-sm text-base-content/85 leading-relaxed text-justify">
                    {!! $bab2->content['fungsional_text'] ?? 'Meliputi pendil, paso, kuali, kendi, gentong air, buyung, dan pedaringan yang dekat dengan kehidupan dapur dan sumur warga. Kendi berfungsi sebagai teknologi pendingin alami. Gentong dan pedaringan menyimbolkan penyimpanan, ketahanan pangan, dan kesiapan rumah tangga yang bersahaja dengan alam.' !!}
                </p>
            </div>

            {{-- Religi --}}
            <div x-show="activeTab === 'religi'" x-transition class="space-y-4">
                <h3 class="font-serif text-xl font-bold text-primary flex items-center gap-2">
                    <span>🕌</span> Kriya Religi &amp; Ritual
                </h3>
                <p class="text-sm text-base-content/85 leading-relaxed text-justify">
                    {!! $bab2->content['religi_text'] ?? 'Diwakili oleh Memolo (mastaka/hiasan pucuk atap kubah masjid kuno Cirebon) dan Padasan (gentong tanah liat berlubang pancuran untuk berwudu). Air wudu yang keluar dari padasan tanah melambangkan kesucian lahir-batin dan pengingat bahwa manusia diciptakan dari unsur tanah yang bersahaja.' !!}
                </p>
            </div>

            {{-- Simbolik --}}
            <div x-show="activeTab === 'simbolik'" x-transition class="space-y-4">
                <h3 class="font-serif text-xl font-bold text-primary flex items-center gap-2">
                    <span>🐉</span> Kriya Simbolik
                </h3>
                <p class="text-sm text-base-content/85 leading-relaxed text-justify">
                    {!! $bab2->content['simbolik_text'] ?? 'Perwujudan makhluk mitologis Cirebonan yang dibentuk menjadi patung tanah liat terakota, seperti Paksinagaliman, Macan Ali, Singabarong, Burok, Jatayu, Garuda Mungkur, dan Gajah Mungkur. Awalnya dibentuk sebagai pernyataan kekuatan, perlindungan, dan penyatuan unsur-unsur kekuasaan tradisional.' !!}
                </p>
            </div>

            {{-- Estetis --}}
            <div x-show="activeTab === 'estetis'" x-transition class="space-y-4">
                <h3 class="font-serif text-xl font-bold text-primary flex items-center gap-2">
                    <span>✨</span> Kriya Estetis &amp; Hias
                </h3>
                <p class="text-sm text-base-content/85 leading-relaxed text-justify">
                    {!! $bab2->content['estetis_text'] ?? 'Meliputi vas bunga kontemporer, pot tanaman, jambangan air hias, dan topeng dinding dekoratif. Kategori ini menyatukan tradisi turun-temurun pengolahan tanah liat lokal dengan inovasi interior modern, menjadi jembatan ekonomi kreatif yang relevan dengan selera pasar modern tanpa menghapus identitas asalnya.' !!}
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Bab 3: Filosofi Ragam Motif --}}
<section class="py-16 px-4 bg-base-200/50 border-y border-base-300/30">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <span class="text-xs uppercase tracking-wider text-accent font-bold">Bab III</span>
            <h2 class="font-serif text-2xl md:text-3xl font-bold text-primary mt-2">Membaca Motif pada Tubuh Gerabah</h2>
            <p class="text-xs md:text-sm text-base-content/60 mt-3 max-w-xl mx-auto">
                {!! $bab3->content['main_desc'] ?? 'Ragam hias Sitiwinangun menjadi pembeda visual utama dari sentra lainnya. Setiap goresan adalah cara masyarakat menitipkan doa dan cerita pada tanah.' !!}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Motif 1 -->
            <div class="card bg-base-100 border border-base-300 p-6 space-y-3 hover:shadow-md transition-shadow duration-300">
                <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold font-serif">
                    I
                </div>
                <h3 class="font-serif font-bold text-primary text-lg">{!! $bab3->content['motif_1_title'] ?? 'Motif Wadasan' !!}</h3>
                <p class="text-xs md:text-sm text-base-content/70 leading-relaxed text-justify">
                    {!! $bab3->content['motif_1_desc'] ?? 'Melambangkan fondasi kehidupan yang kokoh, keteguhan hati, dan kekuatan spiritual masyarakat menghadapi gelombang perubahan zaman.' !!}
                </p>
            </div>

            <!-- Motif 2 -->
            <div class="card bg-base-100 border border-base-300 p-6 space-y-3 hover:shadow-md transition-shadow duration-300">
                <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold font-serif">
                    II
                </div>
                <h3 class="font-serif font-bold text-primary text-lg">{!! $bab3->content['motif_2_title'] ?? 'Motif Mega Mendung' !!}</h3>
                <p class="text-xs md:text-sm text-base-content/70 leading-relaxed text-justify">
                    {!! $bab3->content['motif_2_desc'] ?? 'Awan pembawa hujan lambang kesuburan, kemakmuran, kepemimpinan yang mengayomi, serta ketenangan emosi yang harus dijaga.' !!}
                </p>
            </div>

            <!-- Motif 3 -->
            <div class="card bg-base-100 border border-base-300 p-6 space-y-3 hover:shadow-md transition-shadow duration-300">
                <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold font-serif">
                    III
                </div>
                <h3 class="font-serif font-bold text-primary text-lg">{!! $bab3->content['motif_3_title'] ?? 'Motif Patran' !!}</h3>
                <p class="text-xs md:text-sm text-base-content/70 leading-relaxed text-justify">
                    {!! $bab3->content['motif_3_desc'] ?? 'Liku sulur tumbuhan organik menjalar lambang kelangsungan hidup yang harmonis, pertumbuhan komunal, dan adaptabilitas tanpa batas.' !!}
                </p>
            </div>

            <!-- Motif 4 -->
            <div class="card bg-base-100 border border-base-300 p-6 space-y-3 hover:shadow-md transition-shadow duration-300">
                <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold font-serif">
                    IV
                </div>
                <h3 class="font-serif font-bold text-primary text-lg">{!! $bab3->content['motif_4_title'] ?? 'Motif Pecahan Piring Cina' !!}</h3>
                <p class="text-xs md:text-sm text-base-content/70 leading-relaxed text-justify">
                    {!! $bab3->content['motif_4_desc'] ?? 'Bukti sejarah kuat perdagangan maritim dan kerukunan asimilasi budaya keramik Tiongkok dengan kehangatan terakota lokal.' !!}
                </p>
            </div>

            <!-- Motif 5 -->
            <div class="card bg-base-100 border border-base-300 p-6 space-y-3 hover:shadow-md transition-shadow duration-300">
                <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold font-serif">
                    V
                </div>
                <h3 class="font-serif font-bold text-primary text-lg">{!! $bab3->content['motif_5_title'] ?? 'Motif Flora &amp; Fauna' !!}</h3>
                <p class="text-xs md:text-sm text-base-content/70 leading-relaxed text-justify">
                    {!! $bab3->content['motif_5_desc'] ?? 'Representasi ragam kehidupan alami Cirebon, mengabadikan keindahan hayati pesisir dan hubungan bersahaja manusia dengan alam.' !!}
                </p>
            </div>

            <!-- Motif 6 -->
            <div class="card bg-base-100 border border-base-300 p-6 space-y-3 hover:shadow-md transition-shadow duration-300">
                <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold font-serif">
                    VI
                </div>
                <h3 class="font-serif font-bold text-primary text-lg">{!! $bab3->content['motif_6_title'] ?? 'Ragam Hias Lainnya' !!}</h3>
                <p class="text-xs md:text-sm text-base-content/70 mt-2 leading-relaxed text-justify">
                    {!! $bab3->content['motif_6_desc'] ?? 'Masih banyak motif ornamen lokal seperti <em>Tepen</em>, <em>Rumbing</em>, <em>Untu Walang</em>, <em>Berundakan</em>, <em>Kawung</em>, <em>Bulan Sabit</em>, dan <em>Kaligrafi</em> yang menyusun khazanah estetika organik khas budaya agraris-religius pesisir utara Jawa Barat.' !!}
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Bab 4: Mitologi Cirebon --}}
<section class="py-16 px-4 bg-base-100 border-b border-base-300/30">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <span class="text-xs uppercase tracking-wider text-accent font-bold">Bab IV</span>
            <h2 class="font-serif text-2xl md:text-3xl font-bold text-primary mt-2">Makhluk Penjaga Ingatan</h2>
            <p class="text-xs md:text-sm text-base-content/60 mt-3 max-w-xl mx-auto">
                {!! $bab4->content['main_desc'] ?? 'Bentuk-bentuk mitologi Cirebon yang diwujudkan dalam wujud patung terakota gerabah, menjadi simbol kerukunan akulturasi budaya.' !!}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center" x-data="{ activeMyth: 'paksi' }">
            {{-- Left Side: Interactive List --}}
            <div class="lg:col-span-6 space-y-4">
                {{-- Paksi Naga Liman --}}
                <div @mouseenter="activeMyth = 'paksi'"
                     @click="activeMyth = 'paksi'"
                     :class="activeMyth === 'paksi' ? 'bg-base-200/80 border-primary' : 'border-base-200 hover:bg-base-200/30'"
                     class="p-5 rounded-xl border-l-4 transition-all duration-300 cursor-pointer space-y-2">
                    <h3 class="font-serif font-bold text-xl transition-colors duration-200" :class="activeMyth === 'paksi' ? 'text-primary' : 'text-base-content/85'">
                        Paksi Naga Liman
                    </h3>
                    <p class="text-xs md:text-sm text-base-content/70 leading-relaxed text-justify">
                        {!! $bab4->content['paksi_text'] ?? 'Visual hibrid legendaris yang menggabungkan tiga unsur: <strong>Paksi</strong> (burung/Garuda lambang udara &amp; Nusantara), <strong>Naga</strong> (ular naga lambang lautan &amp; Cina), serta <strong>Liman</strong> (gajah lambang daratan/tanah &amp; India). Penggabungan ketiganya menjadi perlambangan kekuatan kosmologis triloka (dunia atas, tengah, bawah) sekaligus saksi bisu bahwa peradaban Cirebon tumbuh harmonis dari perjumpaan damai berbagai bangsa secara etis.' !!}
                    </p>
                </div>

                {{-- Macan Ali --}}
                <div @mouseenter="activeMyth = 'macan'"
                     @click="activeMyth = 'macan'"
                     :class="activeMyth === 'macan' ? 'bg-base-200/80 border-primary' : 'border-base-200 hover:bg-base-200/30'"
                     class="p-5 rounded-xl border-l-4 transition-all duration-300 cursor-pointer space-y-2">
                    <h3 class="font-serif font-bold text-xl transition-colors duration-200" :class="activeMyth === 'macan' ? 'text-primary' : 'text-base-content/85'">
                        Macan Ali
                    </h3>
                    <p class="text-xs md:text-sm text-base-content/70 leading-relaxed text-justify">
                        {!! $bab4->content['macan_text'] ?? 'Terinspirasi dari keperkasaan Sayidina Ali dan kaligrafi kalimat tauhid Islam yang membentuk tubuh macan dalam bendera Kesultanan Cirebon. Menyimpan pesan keberanian dan perlindungan spiritual yang bersandar pada ketakwaan.' !!}
                    </p>
                </div>

                {{-- Singabarong & Burok --}}
                <div @mouseenter="activeMyth = 'singabarong'"
                     @click="activeMyth = 'singabarong'"
                     :class="activeMyth === 'singabarong' ? 'bg-base-200/80 border-primary' : 'border-base-200 hover:bg-base-200/30'"
                     class="p-5 rounded-xl border-l-4 transition-all duration-300 cursor-pointer space-y-2">
                    <h3 class="font-serif font-bold text-xl transition-colors duration-200" :class="activeMyth === 'singabarong' ? 'text-primary' : 'text-base-content/85'">
                        Singabarong &amp; Burok
                    </h3>
                    <p class="text-xs md:text-sm text-base-content/70 leading-relaxed text-justify">
                        {!! $bab4->content['singabarong_text'] ?? 'Singabarong melambangkan kemegahan wibawa kekuasaan, sementara Burok dikaitkan erat dengan kisah Isra Mi\'raj nabi. Kehadirannya dalam bentuk gerabah memperlihatkan media syiar agama Islam yang menyatu lembut dengan imajinasi kesenian rakyat setempat.' !!}
                    </p>
                </div>
            </div>

            {{-- Right Side: Dynamic Card Display --}}
            <div class="lg:col-span-6 flex justify-center items-center relative min-h-[384px] md:min-h-[400px] w-full">
                {{-- Card Paksi Naga Liman --}}
                <div x-show="activeMyth === 'paksi'"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 translate-y-4 scale-98"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200 transform absolute"
                     class="w-full">
                    <div class="relative w-full max-w-[384px] aspect-square mx-auto rounded-2xl bg-base-200 border border-base-300 p-8 flex flex-col items-center justify-center overflow-hidden shadow-inner">
                        <div class="absolute -right-10 -bottom-10 w-44 h-44 rounded-full bg-accent/5"></div>
                        <div class="absolute -left-10 -top-10 w-44 h-44 rounded-full bg-primary/5"></div>
                        <div class="z-10 text-center space-y-4 max-w-xs flex flex-col items-center">
                            <div class="inline-flex p-3 rounded-full bg-primary/10 text-primary shadow-sm mb-2">
                                <img src="{{ asset('images/mitologi/paksi_naga_liman.png') }}" class="h-16 w-16 object-contain" alt="Paksi Naga Liman">
                            </div>
                            <h4 class="font-serif font-bold text-2xl text-primary">Paksi Naga Liman</h4>
                            <p class="text-xs text-base-content/60 leading-relaxed uppercase tracking-wider font-semibold">
                                Triloka &amp; Akulturasi
                            </p>
                            <div class="divider my-1 opacity-20"></div>
                            <p class="text-xs md:text-sm text-base-content/75 leading-relaxed">
                                {!! $bab4->content['paksi_card_desc'] ?? 'Burung (langit/Nusantara), naga (laut/Cina), dan gajah (darat/India) menyatu dalam satu visual kosmologi Cirebon yang megah.' !!}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card Macan Ali --}}
                <div x-show="activeMyth === 'macan'"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 translate-y-4 scale-98"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200 transform absolute"
                     class="w-full">
                    <div class="relative w-full max-w-[384px] aspect-square mx-auto rounded-2xl bg-base-200 border border-base-300 p-8 flex flex-col items-center justify-center overflow-hidden shadow-inner">
                        <div class="absolute -right-10 -bottom-10 w-44 h-44 rounded-full bg-primary/5"></div>
                        <div class="absolute -left-10 -top-10 w-44 h-44 rounded-full bg-accent/5"></div>
                        <div class="z-10 text-center space-y-4 max-w-xs flex flex-col items-center">
                            <div class="inline-flex p-3 rounded-full bg-accent/10 text-accent shadow-sm mb-2">
                                <img src="{{ asset('images/mitologi/macan_ali.png') }}" class="h-16 w-16 object-contain" alt="Macan Ali">
                            </div>
                            <h4 class="font-serif font-bold text-2xl text-accent">Macan Ali</h4>
                            <p class="text-xs text-base-content/60 leading-relaxed uppercase tracking-wider font-semibold">
                                Spiritual &amp; Keberanian
                            </p>
                            <div class="divider my-1 opacity-20"></div>
                            <p class="text-xs md:text-sm text-base-content/75 leading-relaxed">
                                {!! $bab4->content['macan_card_desc'] ?? 'Lambang perlindungan, kepahlawanan, dan keberanian masyarakat Cirebon yang bertumpu pada ketakwaan spiritual.' !!}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card Singabarong & Burok --}}
                <div x-show="activeMyth === 'singabarong'"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 translate-y-4 scale-98"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200 transform absolute"
                     class="w-full">
                    <div class="relative w-full max-w-[384px] aspect-square mx-auto rounded-2xl bg-base-200 border border-base-300 p-8 flex flex-col items-center justify-center overflow-hidden shadow-inner">
                        <div class="absolute -right-10 -bottom-10 w-44 h-44 rounded-full bg-accent/5"></div>
                        <div class="absolute -left-10 -top-10 w-44 h-44 rounded-full bg-primary/5"></div>
                        <div class="z-10 text-center space-y-4 max-w-xs flex flex-col items-center">
                            <div class="inline-flex p-3 rounded-full bg-primary/10 text-primary shadow-sm mb-2">
                                <img src="{{ asset('images/mitologi/singabarong.png') }}" class="h-16 w-16 object-contain" alt="Singabarong">
                            </div>
                            <h4 class="font-serif font-bold text-2xl text-primary">Singabarong &amp; Burok</h4>
                            <p class="text-xs text-base-content/60 leading-relaxed uppercase tracking-wider font-semibold">
                                Syiar &amp; Kesenian Rakyat
                            </p>
                            <div class="divider my-1 opacity-20"></div>
                            <p class="text-xs md:text-sm text-base-content/75 leading-relaxed">
                                {!! $bab4->content['singabarong_card_desc'] ?? 'Singabarong sebagai lambang kewibawaan tahta kerajaan, dan Burok sebagai pengantar dakwah kultural Islam di pesisir.' !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Bab 5: Kearifan Lokal --}}
<section class="py-16 px-4 bg-base-200/50 border-b border-base-300/30">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <span class="text-xs uppercase tracking-wider text-accent font-bold">Bab V</span>
            <h2 class="font-serif text-2xl md:text-3xl font-bold text-primary mt-2">Kearifan Lokal &amp; Etika Komunal</h2>
            <p class="text-xs md:text-sm text-base-content/60 mt-3 max-w-xl mx-auto">
                {!! $bab5->content['main_desc'] ?? 'Dua tutur kearifan lokal ekonomi moral yang menjadi jaring pengaman sosial warga Desa Sitiwinangun.' !!}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Tutur 1 -->
            <div class="card bg-base-100 border border-base-300 shadow-sm p-8 space-y-4 hover:shadow-md transition-all duration-300">
                <span class="badge badge-accent badge-outline uppercase tracking-wider text-[10px] font-bold">Tutur Ekonomi</span>
                <h3 class="font-serif font-bold text-xl text-primary">"{!! $bab5->content['tutur_1_title'] ?? 'Sugih Ora Rerawat' !!}"</h3>
                <p class="text-xs md:text-sm text-base-content/80 leading-relaxed text-justify">
                    {!! $bab5->content['tutur_1_desc'] ?? 'Artinya: sekaya-kayanya orang Sitiwinangun, hartanya tidak melulu disimpan dalam emas atau kemewahan mencolok yang harus dijaga ketat. Kekayaan mereka disimpan dalam penguasaan keterampilan kriya, tanah liat, dan jalinan persaudaraan.' !!}
                </p>
                <p class="text-xs md:text-sm text-base-content/60 leading-relaxed text-justify italic border-l-2 border-accent/30 pl-3">
                    {!! $bab5->content['tutur_1_subtext'] ?? 'Nilai luhur ini mengajarkan bahwa kekayaan sejati adalah pengetahuan tangan dan jejaring sosial yang produktif—harta hidup yang tidak akan pernah bisa dicuri oleh orang lain.' !!}
                </p>
            </div>

            <!-- Tutur 2 -->
            <div class="card bg-base-100 border border-base-300 shadow-sm p-8 space-y-4 hover:shadow-md transition-all duration-300">
                <span class="badge badge-accent badge-outline uppercase tracking-wider text-[10px] font-bold">Tutur Solidaritas</span>
                <h3 class="font-serif font-bold text-xl text-primary">"{!! $bab5->content['tutur_2_title'] ?? 'Melarat Ora Gegulat' !!}"</h3>
                <p class="text-xs md:text-sm text-base-content/80 leading-relaxed text-justify">
                    {!! $bab5->content['tutur_2_desc'] ?? 'Artinya: semiskin-miskinnya orang Sitiwinangun, mereka tidak harus terusir pergi dari kampung halaman untuk sekadar mencari suap nasi. Ketika seorang pengrajin sepi pesanan, tetangga atau saudaranya akan merangkul mereka.' !!}
                </p>
                <p class="text-xs md:text-sm text-base-content/60 leading-relaxed text-justify italic border-l-2 border-accent/30 pl-3">
                    {!! $bab5->content['tutur_2_subtext'] ?? 'Jejaring komunal bertindak sebagai jaring pengaman ekonomi. Warga saling berbagi tahapan order (misal membantu menjemur, menghias, atau membakar gerabah) agar semua orang tetap memperoleh upah dan hidup layak bersama.' !!}
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
