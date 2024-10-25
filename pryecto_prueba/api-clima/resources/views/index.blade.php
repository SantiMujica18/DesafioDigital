<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informativa</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>
    <div>
        <h1>Consulta tu destino</h1>
        <form id="travelForm">
            <label for="city">Ciudad:</label>

            <select id="city" name="city_id">
                @foreach($cities as $city)
                <option value="{{ $city->name }}">{{ $city->name }}</option>
                @endforeach
            </select>

            <label for="budget">Presupuesto en COP:</label>
            <input type="number" id="budget" name="budget" step="any" required>
            <button type="submit">Consultar</button>

        </form>

        <div id="results" class="none">
            <h2>Resultados:</h2>
            <p>Clima: <span id="temperature"></span> °C</p>
            <p>Moneda: <span id="currency_symbol"></span></p>
            <p>Presupuesto convertido: <span id="budget_local"></span></p>
            <p>Tasa de cambio: <span id="exchange_rate"></span></p>
        </div>
    </div>

    <script>
        $('#travelForm').on('submit', function(e) {
            e.preventDefault();
            var city = $('#city').val();
            var budget = $('#budget').val();

            $.ajax({
                url: "{{ route('get.details') }}",
                method: 'GET',
                data: {
                    city: city,
                },
                success: function(response) {
                    $('#temperature').text(response.clima.weather[0].description + ' ' + (response.clima.main.temp - 273.15).toFixed(2));
                    $('#results').removeClass('none');
                    console.log(response)
                    switch (city) {
                        case "Londres":
                            $('#budget_local').text((budget * response.tasa_cambio.rates["EUR"]).toFixed(0));
                            $('#currency_symbol').text("EUR €");
                            $('#exchange_rate').text(response.tasa_cambio.rates["EUR"]);
                            break;
                        case "Nueva York":
                            $('#budget_local').text((budget * response.tasa_cambio.rates["USD"]).toFixed(0));
                            $('#currency_symbol').text("USD $");
                            $('#exchange_rate').text(response.tasa_cambio.rates["USD"]);
                            break;
                        case "Tokio":
                            $('#budget_local').text((budget * response.tasa_cambio.rates["JPY"]).toFixed(0));
                            $('#currency_symbol').text("JPY ¥");
                            $('#exchange_rate').text(response.tasa_cambio.rates["JPY"]);
                            break;
                        case "Paris":
                            $('#budget_local').text((budget * response.tasa_cambio.rates["EUR"]).toFixed(0));
                            $('#currency_symbol').text("EUR €");
                            $('#exchange_rate').text(response.tasa_cambio.rates["EUR"]);
                            break;
                        case "Madrid":
                            $('#budget_local').text((budget * response.tasa_cambio.rates["EUR"]).toFixed(0));
                            $('#currency_symbol').text("EUR €");
                            $('#exchange_rate').text(response.tasa_cambio.rates["EUR"]);
                            break;
                        default:
                            return "error en el cambio de la moneda";
                            break;
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error al obtener los datos: ' + xhr.responseText);
                }
            });
        });
    </script>
</body>

</html>