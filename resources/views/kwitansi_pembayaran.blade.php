<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>
            {{ @$title != '' ? "$title |" : '' }}  {{ settings()->get('app_name', 'My APP') }}
        </title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: left;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}

		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td width="20%">No.</td>
					<td>: #{{ $pembayaran->id }}</td>
				</tr>
				<tr>
					<td>Telah terima dari</td>
					<td>: {{ $pembayaran->tagihan->siswa->nama }}</td>
				</tr>
				<tr>
					<td>Uang sejumlah</td>
					<td>: <i>{{ ucwords(terbilang($pembayaran->jumlah_dibayar)) }} Rupiah</i></td>
				</tr>
				<tr>
					<td>Untuk pembayaran</td>
					<td>: {{ $pembayaran->tagihan->tagihanDetails->first()->nama_biaya }} {{ $pembayaran->tagihan->tanggal_tagihan->translatedFormat('F Y') }}</td>
				</tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="100%">
                            <tr>
                                <td colspan="2" style="vertical-align: bottom" width="400">
                                   <div style="background:#ccc; width:100px; padding:10px; font-weight:bold">
                                        {{ formatRupiah($pembayaran->jumlah_dibayar) }}
                                   </div>
                                </td>
                                <td colspan="1">
                                    Los Santos, {{ now()->translatedFormat('d F Y') }} <br>
                                    Mengetahui, <br>
                                                <br>
                                                <br>
                                    Bendahara
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
			</table>
            <center>
                <a href="{{ url()->current() . '?output=pdf' }}">Download PDF</a> |
                <a href="#" onclick="window.print()">Cetak</a>
            </center>
		</div>
	</body>
</html>
