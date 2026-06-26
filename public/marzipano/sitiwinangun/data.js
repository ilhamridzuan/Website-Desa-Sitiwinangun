var APP_DATA = {
  "scenes": [
    {
      "id": "0-kampung-gerabah-start",
      "name": "Pintu Masuk Kampung Gerabah (Start)",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -1.3348473603135211,
          "pitch": 0.04444616848669014,
          "rotation": 5.497787143782138,
          "target": "1-jalan-ke-pengrajin-1-dan-2-lurus"
        }
      ],
      "infoHotspots": [
        {
          "yaw": -3.1338784238862836,
          "pitch": -0.024239683896340125,
          "title": "Kantor Desa Sitiwinangun",
          "text": "Pusat administrasi dan pelayanan warga Desa Sitiwinangun. Kantor ini mengelola berbagai program pemberdayaan, termasuk pengembangan industri gerabah sebagai warisan budaya dan sumber penghidupan utama masyarakat setempat."
        }
      ]
    },
    {
      "id": "1-jalan-ke-pengrajin-1-dan-2-lurus",
      "name": "Akses Jalan Lurus Menuju Pengrajin 1 & 2",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 3.071832360364267,
          "pitch": 0.008958904364519071,
          "rotation": 0,
          "target": "0-kampung-gerabah-start"
        },
        {
          "yaw": -0.1362741957004623,
          "pitch": 0.4456701271044956,
          "rotation": 0,
          "target": "2-jalan-ke-pengrajin-1-dan-2-kanan"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "2-jalan-ke-pengrajin-1-dan-2-kanan",
      "name": "Akses Jalan Kanan Menuju Pengrajin 1 & 2",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 1.9412612340514155,
          "pitch": 0.3717931335538829,
          "rotation": 5.497787143782138,
          "target": "1-jalan-ke-pengrajin-1-dan-2-lurus"
        },
        {
          "yaw": -0.19007296056113177,
          "pitch": 0.20515230836268117,
          "rotation": 4.71238898038469,
          "target": "3-jalan-ke-pengrajin-1-dan-2-lurus---kanan"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "3-jalan-ke-pengrajin-1-dan-2-lurus---kanan",
      "name": "Akses Jalan Lurus-Kanan Menuju Pengrajin 1 & 2",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -1.7941161216905321,
          "pitch": 0.10075833972341464,
          "rotation": 4.71238898038469,
          "target": "2-jalan-ke-pengrajin-1-dan-2-kanan"
        },
        {
          "yaw": -0.10716621987767994,
          "pitch": 0.3397099435723483,
          "rotation": 6.283185307179586,
          "target": "4-simpang-pengrajin-1-dan-2"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "4-simpang-pengrajin-1-dan-2",
      "name": "Persimpangan Jalan Menuju Pengrajin 1 & 2",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 3.089028225177147,
          "pitch": 0.2091035968408974,
          "rotation": 0,
          "target": "5-tempat-pembakaran-pengrajin-1"
        },
        {
          "yaw": 1.6893733090204988,
          "pitch": 0.12452928246583284,
          "rotation": 0,
          "target": "7-tempat-pengrajin-2"
        },
        {
          "yaw": 1.422680375545042,
          "pitch": 0.2549430717313754,
          "rotation": 4.71238898038469,
          "target": "3-jalan-ke-pengrajin-1-dan-2-lurus---kanan"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "5-tempat-pembakaran-pengrajin-1",
      "name": "Area Pembakaran Gerabah Pengrajin 1",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 3.099625886572566,
          "pitch": 0.3031090488595094,
          "rotation": 0,
          "target": "6-tempat-pengrajin-1"
        },
        {
          "yaw": 0.005791146294285454,
          "pitch": 0.4161750676899274,
          "rotation": 0,
          "target": "4-simpang-pengrajin-1-dan-2"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "6-tempat-pengrajin-1",
      "name": "Rumah Produksi Gerabah Pengrajin 1",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -2.601433578280224,
          "pitch": 0.4130063192507585,
          "rotation": 7.0685834705770345,
          "target": "5-tempat-pembakaran-pengrajin-1"
        }
      ],
      "infoHotspots": [
        {
          "yaw": -2.812685268306767,
          "pitch": -0.1474975547646764,
          "title": "Gerabah Pak Sariman",
          "text": "Rumah produksi gerabah milik Pak Sariman, salah satu pengrajin senior Desa Sitiwinangun. Berbagai produk gerabah tradisional — dari kendi, gentong, cobek, hingga kuwali — dibuat di sini menggunakan teknik putaran tangan yang diwariskan secara turun-temurun selama lebih dari tiga generasi."
        }
      ]
    },
    {
      "id": "7-tempat-pengrajin-2",
      "name": "Rumah Produksi Gerabah Pengrajin 2",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -0.5586242171860043,
          "pitch": 0.3969410046617661,
          "rotation": 11.780972450961727,
          "target": "8-jalan-ke-pengrajin-3"
        },
        {
          "yaw": 1.6232401623036807,
          "pitch": 0.4362010799354703,
          "rotation": 7.0685834705770345,
          "target": "4-simpang-pengrajin-1-dan-2"
        }
      ],
      "infoHotspots": [
        {
          "yaw": 0.25997053496149825,
          "pitch": 0.009134224774790312,
          "title": "Arkima Pottery",
          "text": "Arkima Pottery adalah studio kerajinan gerabah yang memadukan teknik tradisional Sitiwinangun dengan sentuhan desain modern. Produk unggulannya berupa pot dekorasi, set perabot dapur artistik, dan souvenir khas gerabah yang banyak diminati wisatawan maupun kolektor."
        }
      ]
    },
    {
      "id": "8-jalan-ke-pengrajin-3",
      "name": "Akses Jalan Utama Menuju Pengrajin 3",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 0.40077079528302484,
          "pitch": 0.5216662184683099,
          "rotation": 0,
          "target": "9-jalan-ke-pengrajin-3-kiri"
        },
        {
          "yaw": -2.3129905688662866,
          "pitch": 0.34220711270695325,
          "rotation": 0,
          "target": "7-tempat-pengrajin-2"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "9-jalan-ke-pengrajin-3-kiri",
      "name": "Akses Belok Kiri Menuju Pengrajin 3",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 3.0656966996719275,
          "pitch": 0.32300895408691765,
          "rotation": 0,
          "target": "8-jalan-ke-pengrajin-3"
        },
        {
          "yaw": -1.6086638489388143,
          "pitch": 0.36540479023834216,
          "rotation": 0,
          "target": "10-jalan-ke-pengerajin-3-lurus"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "10-jalan-ke-pengerajin-3-lurus",
      "name": "Akses Jalan Lurus Menuju Pengrajin 3",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -1.66550729249294,
          "pitch": 0.382287048250749,
          "rotation": 0,
          "target": "9-jalan-ke-pengrajin-3-kiri"
        },
        {
          "yaw": 1.5861332478424988,
          "pitch": 0.3700362807408091,
          "rotation": 6.283185307179586,
          "target": "11-jalan-ke-pengrajin-3-lurus--kanan"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "11-jalan-ke-pengrajin-3-lurus--kanan",
      "name": "Akses Jalan Lurus-Kanan Menuju Pengrajin 3",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -0.18245891471468312,
          "pitch": 0.3965713594497231,
          "rotation": 12.566370614359176,
          "target": "12-persimpangan-ke-pengrajin-3-lurus"
        },
        {
          "yaw": -2.6846500149330943,
          "pitch": 0.4281360844712232,
          "rotation": 0,
          "target": "10-jalan-ke-pengerajin-3-lurus"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "12-persimpangan-ke-pengrajin-3-lurus",
      "name": "Persimpangan Jalan Lurus Menuju Pengrajin 3",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -2.912131476945506,
          "pitch": 0.47520562292828217,
          "rotation": 6.283185307179586,
          "target": "13-persimpangan-ke-pengrajin-3"
        },
        {
          "yaw": 0.09643808288398681,
          "pitch": 0.5215586371762413,
          "rotation": 12.566370614359176,
          "target": "11-jalan-ke-pengrajin-3-lurus--kanan"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "13-persimpangan-ke-pengrajin-3",
      "name": "Persimpangan Jalan Utama Menuju Pengrajin 3",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -1.7583692262060833,
          "pitch": 0.3483663456315895,
          "rotation": 0,
          "target": "14-warung-ke-arah-pengrajin-3"
        },
        {
          "yaw": -3.0022386106419034,
          "pitch": 0.2970312784087259,
          "rotation": 11.780972450961727,
          "target": "12-persimpangan-ke-pengrajin-3-lurus"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "14-warung-ke-arah-pengrajin-3",
      "name": "Area Warung Warga Menuju Pengrajin 3",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -0.038740496272231084,
          "pitch": 0.4097431872744881,
          "rotation": 0,
          "target": "15-persimpangan-ke-pengrajin-3-kiri"
        },
        {
          "yaw": 1.2870076657006884,
          "pitch": 0.38944582432083763,
          "rotation": 12.566370614359176,
          "target": "13-persimpangan-ke-pengrajin-3"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "15-persimpangan-ke-pengrajin-3-kiri",
      "name": "Persimpangan Jalan Kiri Menuju Pengrajin 3",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 2.335932417375627,
          "pitch": 0.3640935703111374,
          "rotation": 0,
          "target": "14-warung-ke-arah-pengrajin-3"
        },
        {
          "yaw": -2.3854748003920285,
          "pitch": 0.39588276820251167,
          "rotation": 0,
          "target": "16-jalan-keluar-ke-jalan-raya"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "16-jalan-keluar-ke-jalan-raya",
      "name": "Akses Jalan Keluar Menuju Jalan Raya",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 1.678012439297782,
          "pitch": 0.06660712731351559,
          "rotation": 1.5707963267948966,
          "target": "17-jalan-ke-arah-jalab-raya-kanan"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "17-jalan-ke-arah-jalab-raya-kanan",
      "name": "Akses Jalan Kanan Menuju Jalan Raya",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -2.8128979430450904,
          "pitch": 0.2838044258811845,
          "rotation": 0,
          "target": "18-jalan-ke-pengerajin-3"
        },
        {
          "yaw": 0.4650947910394194,
          "pitch": 0.3493085789467383,
          "rotation": 0,
          "target": "0-kampung-gerabah-start"
        },
        {
          "yaw": -1.1531165648366013,
          "pitch": 0.295612404631612,
          "rotation": 0,
          "target": "16-jalan-keluar-ke-jalan-raya"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "18-jalan-ke-pengerajin-3",
      "name": "Akses Jalan Penghubung Menuju Pengrajin 3",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -1.1208435893232043,
          "pitch": 0.17554783617072012,
          "rotation": 0,
          "target": "19-halaman-pengrajin-3"
        },
        {
          "yaw": -2.197921189159292,
          "pitch": 0.10051345140822576,
          "rotation": 11.780972450961727,
          "target": "22-gapura-masjid-keramat"
        },
        {
          "yaw": 0.14242541688507515,
          "pitch": 0.4077131539601453,
          "rotation": 0.7853981633974483,
          "target": "17-jalan-ke-arah-jalab-raya-kanan"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "19-halaman-pengrajin-3",
      "name": "Halaman Depan Rumah Pengrajin 3",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 0.016646402743273114,
          "pitch": 0.1267910410901365,
          "rotation": 4.71238898038469,
          "target": "18-jalan-ke-pengerajin-3"
        },
        {
          "yaw": 1.8443394828122992,
          "pitch": 0.13138935397249796,
          "rotation": 4.71238898038469,
          "target": "20-tempat-pembakaran-pengrajin-3"
        }
      ],
      "infoHotspots": [
        {
          "yaw": 1.7157240640733775,
          "pitch": -0.02903592253162124,
          "title": "Apik Craft",
          "text": "Apik Craft adalah usaha gerabah yang dirintis oleh generasi muda Sitiwinangun. Menggabungkan cita rasa lokal dengan inovasi desain, Apik Craft menghadirkan produk fungsional sekaligus estetik — mulai dari vas bunga, mug keramik, hingga aksesori rumah bernuansa etnik."
        }
      ]
    },
    {
      "id": "20-tempat-pembakaran-pengrajin-3",
      "name": "Area Pembakaran Gerabah Pengrajin 3",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 3.0198647171639665,
          "pitch": 0.4173753941884435,
          "rotation": 6.283185307179586,
          "target": "21-tempat-pembuatan-kerajinan-pengrajin-3"
        },
        {
          "yaw": -1.139810159887162,
          "pitch": 0.6324838119719427,
          "rotation": 5.497787143782138,
          "target": "19-halaman-pengrajin-3"
        }
      ],
      "infoHotspots": [
        {
          "yaw": -0.07671619033604316,
          "pitch": -0.011181381151155634,
          "title": "Tungku Pembakaran Gerabah",
          "text": "Tungku pembakaran tradisional ini digunakan untuk membakar gerabah mentah pada suhu 700–900°C selama 6–8 jam. Proses pembakaran merupakan tahap paling kritis dalam pembuatan gerabah — menentukan kekuatan, warna, dan daya tahan produk akhir. Kayu bakar lokal digunakan sebagai sumber panas utama."
        }
      ]
    },
    {
      "id": "21-tempat-pembuatan-kerajinan-pengrajin-3",
      "name": "Rumah Produksi Gerabah Pengrajin 3",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -1.9294089955564093,
          "pitch": 0.31396864174933015,
          "rotation": 4.71238898038469,
          "target": "19-halaman-pengrajin-3"
        },
        {
          "yaw": -1.4404158884453775,
          "pitch": 0.36785829687945615,
          "rotation": 0,
          "target": "20-tempat-pembakaran-pengrajin-3"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "22-gapura-masjid-keramat",
      "name": "Area Gapura Utama Masjid Keramat",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -1.6719780848392958,
          "pitch": 0.18357244968844455,
          "rotation": 0,
          "target": "21-tempat-pembuatan-kerajinan-pengrajin-3"
        },
        {
          "yaw": -0.24268966546471304,
          "pitch": 0.3680621767899659,
          "rotation": 0,
          "target": "23-simpang-pengrajin-4-dan-masjid-keramat"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "23-simpang-pengrajin-4-dan-masjid-keramat",
      "name": "Persimpangan Jalan Menuju Pengrajin 4 & Masjid Keramat",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -2.9231480437729918,
          "pitch": 0.31884661949994175,
          "rotation": 0,
          "target": "24-halaman-pengrajin-4"
        },
        {
          "yaw": -1.3514195894878185,
          "pitch": 0.3266057038077914,
          "rotation": 0,
          "target": "22-gapura-masjid-keramat"
        },
        {
          "yaw": 0.4971988776748013,
          "pitch": 0.1979763465915685,
          "rotation": 14.137166941154074,
          "target": "26-jalan-ke-masjid-keramat"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "24-halaman-pengrajin-4",
      "name": "Halaman Depan Rumah Pengrajin 4",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -0.7873434053552124,
          "pitch": 0.34361856859825757,
          "rotation": 0,
          "target": "23-simpang-pengrajin-4-dan-masjid-keramat"
        },
        {
          "yaw": -0.49728833120052407,
          "pitch": 0.47092260442717304,
          "rotation": 19.63495408493622,
          "target": "25-tempat-pengrajin-4"
        }
      ],
      "infoHotspots": [
        {
          "yaw": -0.13390418759985323,
          "pitch": -0.10507961657063802,
          "title": "Galeri Kadmiya Craft",
          "text": "Galeri Kadmiya Craft menawarkan koleksi gerabah pilihan berkualitas tinggi dengan sentuhan ukiran motif batik Cirebon yang khas. Di sini pengunjung tidak hanya bisa berbelanja produk jadi, tetapi juga dapat mengikuti sesi workshop membuat gerabah langsung bersama pengrajin berpengalaman."
        }
      ]
    },
    {
      "id": "25-tempat-pengrajin-4",
      "name": "Rumah Produksi Gerabah Pengrajin 4",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 2.400490412454465,
          "pitch": 0.31180322742125455,
          "rotation": 1.5707963267948966,
          "target": "24-halaman-pengrajin-4"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "26-jalan-ke-masjid-keramat",
      "name": "Akses Jalan Menuju Masjid Keramat",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 0.24022911678104109,
          "pitch": 0.4971653534287448,
          "rotation": 12.566370614359176,
          "target": "27-jalan-di-samping-masjid-keramat"
        },
        {
          "yaw": -2.9189920042627,
          "pitch": 0.37210389821041545,
          "rotation": 0,
          "target": "23-simpang-pengrajin-4-dan-masjid-keramat"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "27-jalan-di-samping-masjid-keramat",
      "name": "Akses Jalan Samping Masjid Keramat",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 1.5742377940694245,
          "pitch": 0.26899342877410426,
          "rotation": 11.780972450961727,
          "target": "28-halaman-masjid-keramat"
        },
        {
          "yaw": -1.4691172644271973,
          "pitch": 0.11062050571919535,
          "rotation": 0,
          "target": "26-jalan-ke-masjid-keramat"
        },
        {
          "yaw": -0.0654477027690401,
          "pitch": 0.3079269511743643,
          "rotation": 6.283185307179586,
          "target": "29-tampak-dalam-masjid-keramat"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "28-halaman-masjid-keramat",
      "name": "Halaman Depan Masjid Keramat",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": -0.585619516729972,
          "pitch": 0.13265357438116965,
          "rotation": 0.7853981633974483,
          "target": "27-jalan-di-samping-masjid-keramat"
        },
        {
          "yaw": 0.14648855636913716,
          "pitch": 0.1262508981985686,
          "rotation": 0,
          "target": "29-tampak-dalam-masjid-keramat"
        },
        {
          "yaw": 2.6305412350325446,
          "pitch": 0.11613985400086868,
          "rotation": 5.497787143782138,
          "target": "0-kampung-gerabah-start"
        }
      ],
      "infoHotspots": [
        {
          "yaw": 0.23396044551916972,
          "pitch": -0.27026147159019764,
          "title": "Masjid Keramat Sitiwinangun",
          "text": "Masjid Keramat Sitiwinangun merupakan salah satu peninggalan bersejarah yang dipercaya dibangun lebih dari 300 tahun lalu. Menjadi pusat kegiatan spiritual dan budaya warga desa, masjid ini memiliki arsitektur kuno bergaya Cirebon dengan ornamen khas yang masih terawat hingga kini. Di dalamnya terdapat ruang ibadah lama (kuno) yang tetap dipertahankan keasliannya."
        }
      ]
    },
    {
      "id": "29-tampak-dalam-masjid-keramat",
      "name": "Interior Utama Masjid Keramat",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 2.9529647228936318,
          "pitch": 0.3539532799709981,
          "rotation": 0,
          "target": "30-tampak-dalam-masjid-keramat-kuno"
        },
        {
          "yaw": -1.3279039969814548,
          "pitch": 0.3166604304463263,
          "rotation": 5.497787143782138,
          "target": "28-halaman-masjid-keramat"
        },
        {
          "yaw": 0.8749000005271892,
          "pitch": 0.4101536696182251,
          "rotation": 0.7853981633974483,
          "target": "27-jalan-di-samping-masjid-keramat"
        }
      ],
      "infoHotspots": []
    },
    {
      "id": "30-tampak-dalam-masjid-keramat-kuno",
      "name": "Interior Masjid Keramat Kuno",
      "levels": [
        {
          "tileSize": 256,
          "size": 256,
          "fallbackOnly": true
        },
        {
          "tileSize": 512,
          "size": 512
        },
        {
          "tileSize": 512,
          "size": 1024
        }
      ],
      "faceSize": 1488,
      "initialViewParameters": {
        "pitch": 0,
        "yaw": 0,
        "fov": 1.5707963267948966
      },
      "linkHotspots": [
        {
          "yaw": 0.6052240995018998,
          "pitch": 0.3413527846221953,
          "rotation": 0,
          "target": "29-tampak-dalam-masjid-keramat"
        }
      ],
      "infoHotspots": []
    }
  ],
  "name": "Project Title",
  "settings": {
    "mouseViewMode": "drag",
    "autorotateEnabled": true,
    "fullscreenButton": false,
    "viewControlButtons": false
  }
};
