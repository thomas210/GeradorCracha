<!-- View onde os crachás são carregados para a conversão em PDF -->
<!DOCTYPE html>
<html>
<body>

<!-- É passado o caminho dos crachás para serem carregado na view -->
@foreach ($crachas as $cracha)
    <img src="{{ $cracha }}">
@endforeach

</body>
</html>
