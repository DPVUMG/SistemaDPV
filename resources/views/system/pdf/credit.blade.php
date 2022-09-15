<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Reporte de créditos por cobrar</title>
    <style>
        #divPrincipal{
            width: 99%; align-items: center; align-content: center; align-self: center;
        }
        #divLogo{
            align-content: center; align-items: center;  text-align: center;
        }
        #divDerecha{
            text-align: right;
        }
        #divInstruccion{
            border: 1px solid; border: 2px solid red; padding: 10px; border-radius: 25px; color: black;
        }
        #divTitulo{
            text-align: center;
            background-color: grey;
            border-radius: 50%;
            color: white;
        }
        #pInstruccion{
            margin-left: 20px; margin-right: 20px; color: black;
        }
        #label30{
            font-size: 30px;
            text-align: center;
            text-transform: uppercase;
        }
        #label40{
            font-size: 40px;
        }
        #label12{
            font-size: 9px;
        }
        #label20{
            font-size: 16px;
            text-align: justify;
        }
        #tableContenido{
            width: 100%; border-collapse: collapse; padding: 15px;
        }
        #pEstadistica{
            text-align: right;
        }
        #img{
            background-size: cover;
            height: 100px;
            border-radius: 50%;
        }
		.datagrid table { border-collapse: collapse; text-align: left; width: 100%; } .datagrid {font: normal 12px/150% Geneva, Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; border: 2px solid #269939; -webkit-border-radius: 8px; -moz-border-radius: 8px; border-radius: 8px; }.datagrid table td, .datagrid table th { padding: 3px 10px; }.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #529902), color-stop(1, #697F2E) );background:-moz-linear-gradient( center top, #529902 5%, #697F2E 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#529902', endColorstr='#697F2E');background-color:#529902; color:#FFFFFF; font-size: 15px; font-weight: bold; border-left: 1px solid #53A82F; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #000000; border-left: 1px solid #6BF4D4;font-size: 12px;font-weight: normal; }.datagrid table tbody .alt td { background: #DBFFD4; color: #000000; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid #269939;background: #E1EEF4;} .datagrid table tfoot td { padding: 0; font-size: 12px } .datagrid table tfoot td div{ padding: 2px; }
        #tablaEstadistica{
            style='width: 100%;'
        }
        #body{
            border: black 1px solid;
            padding: 10px;
            font: normal 12px/150% Geneva, Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body id="body">
    <br><br>
	<header>
        <div id="divPrincipal">
            <div id="divLogo">
                <label id="label20"><b>{{ $title }}</b></label>
                <br><br>
                <label id="label12"><b>{{ $description }}</b></label>
                <br>
                <br>
            </div>
            <br>
        </div>
    </header>

    @if (!is_null($items))
        <div>
            <table class="datagrid" style="width: 100%">
                <thead>
                    <tr>
                    <th style="text-align:center;" scope="col">{{ __('Pedido') }}</th>
                    <th style="text-align:center;" scope="col">{{ __('Cliente') }}</th>
                    <th style="text-align:center;" scope="col">{{ __('Crédito') }}</th>
                    <th style="text-align:center;" scope="col">{{ __('Monto') }}</th>
                    <th style="text-align:center;" scope="col">{{ __('Fecha') }}</th>
                    <th style="text-align:center;" scope="col">{{ __('Días restantes') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                    <td width="40" style="text-align:center;">#{{ $item->order_id }}</td>
                    <td width="100" style="text-align:left;">{{ $item->getUsuarioAttribute() }}</td>
                    <td width="60" style="text-align:center;">{{ $item->credit->getCreditConcatAttribute() }}</td>
                    <td width="100" style="text-align:right;">{{ $item->getTotalConcatAttribute() }}</td>
                    <td width="100" style="text-align:center;">{{ $item->getDateIAttribute().' - '.$item->getDateFAttribute() }}</td>
                    <td width="60" style="text-align:center;">
                        @if ($item->getPasoAttribute())
                            <strong style="color: red;">{{ $item->getRestaAttribute() }}</strong>
                        @else
                            <strong style="color: green;">{{ $item->getRestaAttribute() }}</strong>
                        @endif
                    </td>
                    </tr>
                @endforeach
                </tbody>

                <tfoot>
                <tr>
                    <th style="text-align:left; background: grey;" colspan="6" scope="col">{{ $footer }}</th>
                </tr>
                </tfoot>
            </table>
        </div>
    @endif

    <script type="text/php">
        if ( isset($pdf) ) {
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $pdf->page_text(500, 745, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
        }
    </script>
</body>
</html>
