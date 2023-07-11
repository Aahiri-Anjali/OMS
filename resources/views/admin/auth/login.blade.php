<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>Order Management System</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href={{ asset('admin/images/apple-touch-icon.png') }} />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href={{ asset('admin/css/core.css') }} />
    <link rel="stylesheet" type="text/css" href={{ asset('admin/css/icon-font.min.css') }} />
    <link rel="stylesheet" type="text/css" href={{ asset('admin/css/style1.css') }} />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "G-GBZ3SGGX85");
    </script>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                "gtm.start": new Date().getTime(),
                event: "gtm.js"
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != "dataLayer" ? "&l=" + l : "";
            j.async = true;
            j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
    </script>
    <!-- End Google Tag Manager -->
</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="login.html">
                    <img src={{ asset('admin/images/deskapp-logo.svg') }} alt="" />
                </a>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <form action="{{ route('admin.login') }}" method="post">
                @csrf
                <div class="row align-items-center">
                    <div class="col-md-6 col-lg-7">
                        <img src={{ asset('admin/images/register-page-img.png') }} alt="" />
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div class="login-box bg-white box-shadow border-radius-10">
                            <div class="login-title">
                                <h2 class="text-center text-primary">Admin Login</h2>
                            </div>
                            <form>
                                <div class="select-role">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn active">
                                            <input type="radio" name="options" id="admin" />
                                            <div class="icon">
                                                <img src={{ asset('admin/images/briefcase.svg') }} class="svg"
                                                    alt="" />
                                            </div>
                                            <span>I'm</span>
                                            Admin
                                        </label>
                                    </div>
                                </div>
                                <div class="input-group custom">
                                    <input type="text"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        name="email" id="name" placeholder="Username" />
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="input-group custom">
                                    <input type="password"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        name="password" id="password" placeholder="**********" />
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                               
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group mb-0">                                          
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Sign
                                                In</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- js -->
    <script src={{ asset('admin/js/core.js') }}></script>
    <script src={{ asset('admin/js/script.min.js') }}></script>
    <script src={{ asset('admin/js/process.js') }}></script>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0"
            style="display: none; visibility: hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
</body>

</html>
