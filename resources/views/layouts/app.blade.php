<!DOCTYPE html> 
<html lang="en" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    
    @php
        $appHost = request()->getHttpHost();
        if (str_contains($appHost, 'localhost') || str_contains($appHost, '127.0.0.1')) {
            $canonicalDomain = 'https://physiopii.in';
        } else {
            $canonicalDomain = (request()->isSecure() ? 'https://' : 'http://') . $appHost;
        }
        $defaultPreviewImg = $canonicalDomain . '/assets/img/og-preview.png';
        $defaultSquareImg  = $canonicalDomain . '/assets/img/og-square.png';
        $currentCanonical  = $canonicalDomain . (request()->getPathInfo() == '/' ? '/' : request()->getPathInfo());
    @endphp

    {{-- ── 1. PRIMARY SEO META TAGS ── --}}
    <title>@yield('title', 'Physiopii — Expert Physiotherapy Care at Home & Online Consultation')</title>
    <meta name="description" content="@yield('meta_description', 'Book certified & experienced physiotherapists for home visits and online consultations across India. Expert care for Back Pain, Knee Pain, Stroke Rehabilitation, Cervical Spondylosis & Sports Injuries.')">
    <meta name="keywords" content="@yield('meta_keywords', 'physiotherapy, home physiotherapy, online physiotherapy consultation, physiotherapist near me, back pain relief, knee pain physiotherapy, stroke rehabilitation, cervical spondylosis treatment, sports injury rehab, physio at home India, best physiotherapist')">
    <meta name="author" content="Physiopii Healthcare">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
    <link rel="canonical" href="@yield('canonical', $currentCanonical)">
    <meta name="rating" content="General">
    <meta name="revisit-after" content="2 days">
    <meta name="language" content="English">
    <meta name="geo.region" content="IN">
    <meta name="geo.placename" content="India">

    {{-- ── 2. OPEN GRAPH META TAGS (WhatsApp, Facebook, LinkedIn, Telegram, iMessage) ── --}}
    <meta property="og:site_name" content="Physiopii">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'Physiopii — Expert Physiotherapy Care at Home & Online')">
    <meta property="og:description" content="@yield('og_description', 'Book certified physiotherapists for personalized home visits and online consultations across India. Specialized treatment for Back Pain, Knee Pain, Stroke Rehab & Sports Injuries.')">
    <meta property="og:url" content="@yield('og_url', $currentCanonical)">
    
    <!-- Primary High-Resolution Social Card (1200x630) -->
    <meta property="og:image" content="@yield('og_image', $defaultPreviewImg)">
    <meta property="og:image:secure_url" content="@yield('og_image', $defaultPreviewImg)">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="@yield('og_image_width', '1200')">
    <meta property="og:image:height" content="@yield('og_image_height', '630')">
    <meta property="og:image:alt" content="Physiopii - Advanced Physiotherapy & Rehabilitation Services">
    
    <!-- Square Thumbnail for WhatsApp, Telegram & Mobile Messengers -->
    <meta property="og:image" content="{{ $defaultSquareImg }}">
    <meta property="og:image:secure_url" content="{{ $defaultSquareImg }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">
    <meta property="og:locale" content="en_IN">

    <!-- Schema & Link microdata for crawlers -->
    <link rel="image_src" href="@yield('og_image', $defaultPreviewImg)">
    <meta itemprop="name" content="@yield('title', 'Physiopii — Expert Physiotherapy Care at Home & Online Consultation')">
    <meta itemprop="description" content="@yield('meta_description', 'Book certified physiotherapists for personalized home visits and online consultations across India.')">
    <meta itemprop="image" content="@yield('og_image', $defaultPreviewImg)">

    {{-- ── 3. TWITTER / X CARD META TAGS ── --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@physiopii">
    <meta name="twitter:creator" content="@physiopii">
    <meta name="twitter:title" content="@yield('twitter_title', 'Physiopii — Expert Physiotherapy Care at Home & Online')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Book certified physiotherapists for home visits & online care. Specialized treatment for Back Pain, Knee Pain, Stroke Rehab & Sports Injuries.')">
    <meta name="twitter:image" content="@yield('twitter_image', $defaultPreviewImg)">
    <meta name="twitter:image:alt" content="Physiopii - Physiotherapy Platform">

    {{-- ── 4. FAVICONS, APP ICONS & WEB MANIFEST ── --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#0c6978">
    <meta name="msapplication-TileColor" content="#0c6978">
    <meta name="msapplication-TileImage" content="{{ asset('assets/img/apple-touch-icon.png') }}">

    {{-- ── 5. CORE STYLES ── --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    {{-- ── 6. STRUCTURED DATA / JSON-LD SCHEMA ── --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": ["MedicalBusiness", "Physiotherapy"],
          "@id": "https://physiopii.in/#organization",
          "name": "Physiopii",
          "alternateName": "Physiopii Healthcare",
          "url": "https://physiopii.in",
          "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('logo.png') }}",
            "caption": "Physiopii Logo"
          },
          "image": "{{ asset('assets/img/og-preview.png') }}",
          "description": "Physiopii connects patients with certified, experienced physiotherapists for personalized home visits and online consultations across India.",
          "telephone": "+91-9520018563",
          "email": "support@physiopii.in",
          "priceRange": "₹₹",
          "areaServed": {
            "@type": "Country",
            "name": "India"
          },
          "medicalSpecialty": [
            "Physiotherapy",
            "Musculoskeletal",
            "Neurology",
            "SportsMedicine",
            "Geriatrics"
          ],
          "availableService": [
            {
              "@type": "MedicalTherapy",
              "name": "Home Physiotherapy Visits",
              "description": "Certified physiotherapists provide personalized rehabilitation at the patient's home."
            },
            {
              "@type": "MedicalTherapy",
              "name": "Online Video Consultation",
              "description": "1-on-1 virtual physiotherapy guidance, exercise prescription, and posture correction."
            },
            {
              "@type": "MedicalTherapy",
              "name": "Stroke & Neurological Rehabilitation",
              "description": "Dedicated neuro-rehabilitation therapy for stroke recovery, mobility, and motor function."
            },
            {
              "@type": "MedicalTherapy",
              "name": "Back & Neck Pain Relief",
              "description": "Evidence-based manual therapy and exercises for sciatica, spondylosis, and spinal health."
            }
          ]
        },
        {
          "@type": "WebSite",
          "@id": "https://physiopii.in/#website",
          "url": "https://physiopii.in",
          "name": "Physiopii",
          "publisher": {
            "@id": "https://physiopii.in/#organization"
          },
          "potentialAction": {
            "@type": "SearchAction",
            "target": {
              "@type": "EntryPoint",
              "urlTemplate": "https://physiopii.in/search-doctors?search={search_term_string}"
            },
            "query-input": "required name=search_term_string"
          }
        }
      ]
    }
    </script>
    @yield('extra_json_ld')

    <!-- jQuery and Bootstrap Core JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</head>
<body>

    @yield('content')

    <!-- Slick JS -->
    <script src="{{ asset('assets/js/slick.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: @json(session('success')),
            confirmButtonColor: '#0c6978'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: @json(session('error')),
            confirmButtonColor: '#e74c3c'
        });
    </script>
    @endif

    @if(session('warning'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: @json(session('warning')),
            confirmButtonColor: '#f39c12'
        });
    </script>
    @endif

    @if(session('info'))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Information',
            text: @json(session('info')),
            confirmButtonColor: '#0c6978'
        });
    </script>
    @endif

    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
    </script>
    @endif

    @yield('scripts')
</body>
</html>