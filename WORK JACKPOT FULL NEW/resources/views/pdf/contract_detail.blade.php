<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body{padding: 13px; font-size: 11.55px;font-family: DejaVu Sans;}
		.container-fluid{margin-top: 80px;}
		.container-fluid p{padding: 1px;}
		.customer_detail{margin-bottom: 10px;}
		.next_div{margin-bottom: 18px;}
		.main_first_div{width: 100%;margin-bottom: 30px;margin-top: -40px}
		.main_first_div_left{float: left;}
		.main_first_div_right{float: right; margin-top: -18px;}
		.first-child{width: 2%;}
		.second-child{width: 60%;}
		tbody tr{margin-bottom:30px;}
		tbody tr td{vertical-align: top;}
	</style>
</head>
<body>
	<div class="main_first_div" >
		<div  class="main_first_div_left">
			<img src="{{ asset('assets/images/logo.png') }}">
		</div>
		<div class="main_first_div_right">
			<h4>Workjackpot.com ({{$contract_detail['signing_date']}})</h4>
		</div>
	</div>
	<div class="container-fluid next_div" style="margin-top: 80px;">

		<div class="customer_detail">
			<b>Arbeitsvertragsnummer</b> (Numer umowy o pracę):  {{$contract_detail['contract_id']}}
			<br>
			<b>Arbeitsnummer</b> (Numer oferty pracy): {{$contract_detail['job_id']}}
		</div>
		
		<div class="customer_detail">
			<b>Vereinbarung zwischen (Umowa pomiędzy):</b>
		</div>
		<div class="customer_detail">	
			<b>- Zeitarbeitsunternehmen (Agencją pracy tymczasowej):</b>
			<br>
				Workjackpot Grzegorz Dembniak, Wspólna 3, 44-348 Skrzyszów, Polska
		</div>
	
		<div class="customer_detail">
			<b>- Zeitarbeitnehmer (Pracownikiem tymczasowym):</b>
			<br>
			{{$contract_detail['customer_name']}}, {{$contract_detail['customer_street']}} , {{$contract_detail['customer_zip_code']}} ,{{$contract_detail['customer_city']}} ,{{$contract_detail['customer_country']}}
		</div>

		<div class="customer_detail">
			<b>- Benutzer Arbeitgeber (Pracodawcą użytkownikiem):</b>
			<br>
			{{$contract_detail['employer_name']}}, {{$contract_detail['employer_street']}} , {{$contract_detail['employer_zip_code']}} ,{{$contract_detail['employer_city']}} ,{{$contract_detail['employer_country']}}
		</div>
	</div>

	<div class="next_div">
		<b>1. Benutzer Arbeitgeber verpflichtet sich gegenüber dem Zeitarbeitnehmer (Pracodawca użytkownik
		zobowiązuje się względem pracownika tymczasowego):</b>
	</div>

	<div class="next_div">
		<table>
			<tbody>
				<tr>
					<td class="first-child"><b>A.</b></td>
					<td class="second-child">Einsatz als (Zatrudniony jako):</td>
					<td>{{$contract_detail['profession_name']}}</td>
				</tr>
				<tr>
					<td class="first-child"><b>B.</b></td>
					<td class="second-child">Zulassungsvoraussetzungen (Warunek zatrudnienie):</td>
					<td>{{$contract_detail['profession_name']}}</td>
				</tr>
				<tr>
					<td class="first-child"><b>C.</b></td>
					<td class="second-child">Arbeitsort (Miejsce pracy):</td>
					<td>{{$contract_detail['work_location']}}</td>
				</tr>
				<tr>
					<td class="first-child"><b>D.</b></td>
					<td class="second-child">Einsatzbeginn (Początek pracy):</td>
					<td>{{$contract_detail['work_location']}}</td>
				</tr>
				<tr>
					<td class="first-child"><b>E.</b></td>
					<td class="second-child">Arbeitszeit (Wymiar czasu pracy):</td>
					<!-- <td>full-time , {{$contract_detail['working_hours']}}/Week</td> -->
					<td>{{$contract_detail['working_hours']}} Stunden/Woche (godzin/tydzień)</td>
				</tr>
				<tr>
					<td class="first-child"><b>F.</b></td>
					<td class="second-child"> Bruttolohn inkl. Ferien,Feirtage, 13. Gehalt (Wynagrodzenie brutto z uwzględnieniem urlopów, dni wolnych od pracy, 13 pensji):</td>
					<td>{{$contract_detail['salary']}} Euro/Studen (Euro/godzinę)</td>
				</tr>
				<tr>
					<td class="first-child"><b>G.</b></td>
					<td colspan="2">. Einsatzdauer: Dieser Vertrag hat eine maximale Laufzeit von 3 Monaten und endet danach ohne beendung des
					Arbeitsverhältnisses. Diese Vereinbarung kann in dieser Zeit unter Einhaltung der Kündigungsfrist gekündigt oder
					durch schriftliche Zustimmung aller Vertragsparteien verlängert werden (Czas trwania umowy: Umowa ta ma
					maksymalny okres 3 miesięcy i kończy się po tym okresie bez rozwiązania stosunku pracy. Niniejsza umowa może
					zostać rozwiązana w tym okresie z zachowaniem okresu wypowiedzenia lub przedłużona za pisemną zgodą wszystkich
					umawiających się stron);</td>
				</tr>
				<tr>
					<td class="first-child"><b>H.</b></td>
					<td colspan="2">Alle gesetzlich vorgeschriebenen Beiträge, einschließlich Rentenbeiträge, vom Zeitarbeitnehmern Lohn, zu zahlen
					-wird im anderen Vertrag zwishen Benutzer Arbeitgeber und Zeitarbeitnehmer geregelt (Opłacanie wszystkich
					ustawowych składek, w tym składek emerytalnych, od wynagrodzenia pracownika tymczasowego - reguluje inna
					umowa między pracodawcą użytkownikem a pracownikiem tymczlasowym)</td>
				</tr>
				<tr>
					<td class="first-child"><b>I.</b></td>
					<td colspan="2"> Übernimmt die Aufgaben des Arbeitsschutzes, insbesondere die Ausstattung eines Zeitarbeitnehmers mit
					Arbeitskleidung und -Schuhen sowie persönlicher Schutzausrüstung, die Durchführung von Schulungen im Bereich des
					Arbeitsschutzes, die Feststellung von Unfallumständen und -ursachen bei der Arbeit, Durchführung einer
					Gefährdungsbeurteilung am Arbeitsplatz und Aufklärung über diese Gefährdung (Przejmuje obowiązki dotyczące
					bezpieczeństwa i higieny pracy, obejmujących w szczególności dostarczanie pracownikowi tymczasowemu odzieży i
					obuwia roboczego oraz środków ochrony indywidualnej, przeprowadzanie szkolenia w zakresie bezpieczeństwa i
					higieny pracy, ustalenie okoliczności i przyczyny wypadku przy pracy, przeprowadzanie oceny ryzyka zawodowego
					oraz informowanie o tym ryzyku);</td>
				</tr>
				<tr>
					<td class="first-child"><b>J.</b></td>
					<td colspan="2">Auszahlung von Zulagen gemäss der Unternehmensrichtlinien des Benutzer Arbeitgebers, gegenüber
					Zeitarbeitnehmer zu zahlen (Wypłacanie dodatków zgodnie z polityką firmy pracodawcy użytkownika, wypłacanych
					pracownikowi tymczasowemu).</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="next_div">
		<b>2. Zeitarbeitsunternehmen vermittelt zwischen dem Zeitarbeitnehmer und dem Benutzer Arbeitgeber
		und sorgt für eine gute gegenseitige Zusammenarbeit (Agencja pracy tymczasowej pośredniczy
		pomiędzy pracownikiem tymczasowym a pracodawcą użytkownikiem oraz troszczy się o dobrą
		wzajemną współpracę).</b>
	</div>
	
	<div>Es ist ein elektronisches Dokument und erfordert keine Unterschrift (To jest dokument elektroniczny i nie wymaga podpisu).</div>
</body>
</html>