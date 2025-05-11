
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FashionHub Product Page</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: #f9fafb;
            color: #1f2937;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: '>';
        }

        .thumb img {
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: .5rem;
        }

        .thumb.selected img {
            border-color: #0d6efd;
        }

        .color-swatch,
        .size-swatch {
            cursor: pointer;
        }

        .color-swatch.selected,
        .size-swatch.selected {
            border: 2px solid #0d6efd;
        }

        .quantity-btn {
            width: 2.5rem;
        }
    </style>

