<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DoDoors - страница ошибки</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body>
<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="text-center">
        <h1 class="display-1 fw-bold">400</h1>
        <p class="fs-3"> <span class="text-danger">Упс!</span> Ошибка запроса.</p>
        <p class="lead">
            {!! $message ?? 'Ошибка' !!}
        </p>
        <a href="javascript:void(0)"
           onclick="window.close()"
           class="btn btn-primary">Закрыть страницу</a>
    </div>
</div>
</body>


</html>
