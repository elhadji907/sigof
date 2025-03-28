<!DOCTYPE html>
<html>

<head>
    <title>Importation des Arrivées</title>
</head>

<body>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                <strong>{{ $error }}</strong>
            </div>
        @endforeach
    @endif
    <form action="{{ route('import.arrives') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Importer Arrivées</button>
    </form>
</body>

</html>
