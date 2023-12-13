<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body{padding: 13px; font-size: 14px;}
		.container-fluid{margin-top: 70px;}
		.container-fluid p{padding: 1px;}
		.customer_detail{margin-bottom: 10px;}
		.next_div{margin-bottom: 20px;}

		.main_first_div{width: 100%;margin-bottom: 20px;margin-top: -40px}
		.main_first_div_left{float: left;}
		.main_first_div_right{float: right; margin-top: -18px;}

		/*tbody td:first-child {
		  width: 1%;
		}
		tbody td:nth-child(2) {
		  width: 60%;
		}*/
		
		.first-child{width: 2%;}
		.second-child{width: 60%;}
		tbody tr{margin-bottom:30px;}
		tbody tr td{vertical-align: top;}
	</style>
</head>
<body>
	<div class="main_first_div">
		<div  class="main_first_div_left">
			<img src="{{ asset('assets/images/logo.png') }}">
		</div>
		<div class="main_first_div_right">
			<h4>Workjackpot.com ({{$contract_detail['signing_date']}})</h4>
		</div>
	</div>

	<div class="container-fluid next_div">

		<div class="customer_detail">
			<b>Arbeitsvertragsnummer</b> (Numer umowy o prace):  {{$contract_detail['contract_id']}}
			<br>
			<b>Arbeitsnummer</b> (Numer oferty pracy): {{$contract_detail['job_id']}}
		</div>
		
		<div class="customer_detail">
			<b>Vereinbarung zwischen (Umowa pomiedzy):</b>
		</div>
		<div class="customer_detail">	
			<b>- Zeitarbeitsunternehmen (Agencja pracy tymczasowej):</b>
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
		<b>1. Benutzer Arbeitgeber verpflichtet sich gegenüber dem Zeitarbeitnehmer (Pracodawca uzytkownik zobowiazuje sie wzgledem pracownika tymczasowego):</b>
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
					<td class="second-child">Zulassungsvoraussetzungen (Warunek zatrudnienia):</td>
					<td>{{$contract_detail['profession_name']}}</td>
				</tr>
				<tr>
					<td class="first-child"><b>C.</b></td>
					<td class="second-child">Arbeitsort (Miejsce pracy):</td>
					<td>{{$contract_detail['work_location']}}</td>
				</tr>
				<tr>
					<td class="first-child"><b>D.</b></td>
					<td class="second-child">Einsatzbeginn (Poczatek pracy):</td>
					<td>{{$contract_detail['work_location']}}</td>
				</tr>
				<tr>
					<td class="first-child"><b>E.</b></td>
					<td class="second-child">Arbeitszeit (Wymiar czasu pracy):</td>
					<td>full-time , {{$contract_detail['working_hours']}}/Week</td>
				</tr>
				<tr>
					<td class="first-child"><b>F.</b></td>
					<td class="second-child">Bruttolohn inkl. Ferien,Feirtage, 13. Gehalt (Wynagrodzenie brutto z uwzglednieniem urlopów, dni wolnych od pracy, 13 pensji):</td>
					<td>$/{{$contract_detail['salary']}}</td>
				</tr>
				<tr>
					<td class="first-child"><b>G.</b></td>
					<td colspan="2">Einsatzdauer: Dieser Vertrag hat eine maximale Laufzeit von 3 Monaten und endet danach ohne beendung des Arbeitsverhaltnisses. Diese Vereinbarung kann in dieser Zeit unter Einhaltung der Kündigungsfrist gekündigt oder
					durch schriftliche Zustimmung aller Vertragsparteien verlangert werden (Czas trwania umowy: Umowa ta ma
					maksymalny okres 3 miesiecy i konczy sie po tym okresie bez rozwiazania stosunku pracy. Niniejsza umowa moze
					zostac rozwiazana w tym okresie z zachowaniem okresu wypowiedzenia lub przedluzona za pisemna zgoda wszystkich
					umawiajacych sie stron);</td>
				</tr>
				<tr>
					<td class="first-child"><b>H.</b></td>
					<td colspan="2">Alle gesetzlich vorgeschriebenen Beitrage, einschließlich Rentenbeitrage, vom Zeitarbeitnehmern Lohn, zu zahlen -wird im anderen Vertrag zwishen Benutzer Arbeitgeber und Zeitarbeitnehmer geregelt (Oplacanie wszystkich
					ustawowych skladek, w tym skladek emerytalnych, od wynagrodzenia pracownika tymczasowego - reguluje inna
					umowa miedzy pracodawca uzytkownikem a pracownikiem tymcasowym);</td>
				</tr>
				<tr>
					<td class="first-child"><b>I.</b></td>
					<td colspan="2">Übernimmt die Aufgaben des Arbeitsschutzes, insbesondere die Ausstattung eines Zeitarbeitnehmers mit
					Arbeitskleidung und -Schuhen sowie persönlicher Schutzausrüstung, die Durchführung von Schulungen im Bereich des
					Arbeitsschutzes, die Feststellung von Unfallumstanden und -ursachen bei der Arbeit, Durchführung einer
					Gefahrdungsbeurteilung am Arbeitsplatz und Aufklarung über diese Gefahrdung (Przejmuje obowiazki dotyczace
					bezpieczenstwa i higieny pracy, obejmujacych w szczególnosci dostarczanie pracownikowi tymczasowemu odziezy i
					obuwia roboczego oraz srodków ochrony indywidualnej, przeprowadzanie szkolenia w zakresie bezpieczenstwa i
					higieny pracy, ustalenie okolicznosci i przyczyny wypadku przy pracy, przeprowadzanie oceny ryzyka zawodowego
					oraz informowanie o tym ryzyku);</td>
				</tr>
				<tr>
					<td class="first-child"><b>J.</b></td>
					<td colspan="2">Auszahlung von Zulagen gemass der Unternehmensrichtlinien des Benutzer Arbeitgebers, gegenüber
					Zeitarbeitnehmer zu zahlen (Wyplacanie dodatków zgodnie z polityka firmy pracodawcy uzytkownika, wyplacanych
					pracownikowi tymczasowemu).</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="next_div">
		<b>2. Zeitarbeitsunternehmen vermittelt zwischen dem Zeitarbeitnehmer und dem Benutzer Arbeitgeber
		und sorgt für eine gute gegenseitige Zusammenarbeit (Agencja pracy tymczasowej posredniczy
		pomiedzy pracownikiem tymczasowym a pracodawca uzytkownikiem oraz troszczy sie o dobra
		wzajemna wspólprace).</b>
	</div>
	
	<div>Es ist ein elektronisches Dokument und erfordert keine Unterschrift (To jest dokument elektroniczny i nie wymaga podpisu)</div>
</body>
</html>