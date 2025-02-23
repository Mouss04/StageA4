<head>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Lightbox CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
</head>

<body>
    <!-- Contenu de ta page -->

    <!-- Bootstrap JS (avec Popper.js intégré dans bundle) -->
    <script src="{{ asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <!-- <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'alwaysShowNavOnTouchDevices': true
        });
    </script> -->
    <script>
        function showEditForm(questionId) {
            document.getElementById('view-question-' + questionId).style.display = 'none';
            document.getElementById('edit-question-' + questionId).style.display = 'block';
        }

        function hideEditForm(questionId) {
            document.getElementById('edit-question-' + questionId).style.display = 'block';
            document.getElementById('edit-question-' + questionId).style.display = 'none';
        }
    </script>

</body>
