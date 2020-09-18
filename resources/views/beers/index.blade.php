<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Beer</th>
                <th>Style</th>
                <th>Hops</th>
                <th>Yeasts</th>
                <th>Malts</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($beers as $beer)
                <tr>
                    <td>{{ $beer->name }}</td>
                    <td>{{ $beer->style?->name }}</td>
                    <td>
                        @foreach ($beer->hops as $hop)
                            {{ $hop->name }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach ($beer->yeasts as $yeast)
                            {{ $yeast->name }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach ($beer->malts as $malt)
                            {{ $malt->name }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
