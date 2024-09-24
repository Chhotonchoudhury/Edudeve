<!DOCTYPE html>
@php
$menuFixed = ($configData['layout'] === 'vertical') ? ($menuFixed ?? '') : (($configData['layout'] === 'front') ? '' : $configData['headerType']);
$navbarType = ($configData['layout'] === 'vertical') ? $configData['navbarType']: (($configData['layout'] === 'front') ? 'layout-navbar-fixed': '');
$isFront = ($isFront ?? '') == true ? 'Front' : '';
$contentLayout = (isset($container) ? (($container === 'container-xxl') ? "layout-compact" : "layout-wide") : "");
@endphp

<html lang="{{ session()->get('locale') ?? app()->getLocale() }}" class="{{ $configData['style'] }}-style {{($contentLayout ?? '')}} {{ ($navbarType ?? '') }} {{ ($menuFixed ?? '') }} {{ $menuCollapsed ?? '' }} {{ $menuFlipped ?? '' }} {{ $menuOffcanvas ?? '' }} {{ $footerFixed ?? '' }} {{ $customizerHidden ?? '' }}" dir="{{ $configData['textDirection'] }}" data-theme="{{ $configData['theme'] }}" data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{url('/')}}" data-framework="laravel" data-template="{{ $configData['layout'] . '-menu-' . $configData['theme'] . '-' . $configData['style'] }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title') |
    {{ config('variables.templateName') ? config('variables.templateName') : 'TemplateName' }} -
    {{ config('variables.templateSuffix') ? config('variables.templateSuffix') : 'TemplateSuffix' }}</title>
  <meta name="description" content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
  <meta name="keywords" content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Canonical SEO -->
  <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ config('app.favicon') }}" />

  <!-- Include Styles -->
  <!-- $isFront is used to append the front layout styles only on the front layout otherwise the variable will be blank -->
  @include('layouts/sections/styles' . $isFront)

  <!-- Include Scripts for customizer, helper, analytics, config -->
  <!-- $isFront is used to append the front layout scriptsIncludes only on the front layout otherwise the variable will be blank -->
  @include('layouts/sections/scriptsIncludes' . $isFront)
  
</head>

<body>

  <!-- Layout Content -->
  @yield('layoutContent')
  <!--/ Layout Content -->

  <!-- Include Scripts -->
  <!-- $isFront is used to append the front layout scripts only on the front layout otherwise the variable will be blank -->
  @include('layouts/sections/scripts' . $isFront)

  <script>
    class FormSubmitHandler {
    constructor(formId, buttonId, buttonTextId, spinnerId) {
        this.form = document.getElementById(formId);
        this.submitButton = document.getElementById(buttonId);
        this.buttonText = document.getElementById(buttonTextId);
        this.loadingSpinner = document.getElementById(spinnerId);

        this.initialize();
    }

    initialize() {
        if (this.form && this.submitButton && this.buttonText && this.loadingSpinner) {
            this.form.addEventListener('submit', () => {
                this.handleSubmit();
            });
        }
    }

    handleSubmit() {
        // Disable the button
        this.submitButton.disabled = true;
        // Show the loading spinner and change text
        this.loadingSpinner.classList.remove('d-none');
        this.buttonText.textContent = 'Loading...';
    }
}

  </script>

  @if(session('success'))
  <script>
      toastr.success("{{ session('success') }}", 'Success', {
          closeButton: true,
          progressBar: true,
          positionClass: "toast-top-right",
          timeOut: 5000,
          extendedTimeOut: 1000,
          showMethod: "fadeIn",
          hideMethod: "fadeOut"
      });
  </script>
  @endif

  @if(session('warning'))
  <script>
      toastr.warning("{{ session('warning') }}", 'Warning', {
          closeButton: true,
          progressBar: true,
          positionClass: "toast-top-right",
          timeOut: 5000,
          extendedTimeOut: 1000,
          showMethod: "fadeIn",
          hideMethod: "fadeOut"
      });
  </script>
  @endif

  @if(session('error'))
  <script>
      toastr.error("{{ session('error') }}", 'Error', {
          closeButton: true,
          progressBar: true,
          positionClass: "toast-top-right",
          timeOut: 5000,
          extendedTimeOut: 1000,
          showMethod: "fadeIn",
          hideMethod: "fadeOut"
      });
  </script>
  @endif
  @yield('scripts')

</body>

</html>
