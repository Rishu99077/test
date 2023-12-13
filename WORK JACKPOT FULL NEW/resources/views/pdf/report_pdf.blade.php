<!DOCTYPE html>
<html>
   <head>
      <title></title>
      <style type="text/css">
      	body{font-size: 10.5px;font-family: DejaVu Sans;}
      	.table-top tr th img{width: 110px;height: 70px;padding: 15px}
      	.inner-table tr td{width: 100px;text-align: center;}
      	.data-table tbody tr td{height: 20px;text-align: center;}
      	.data-table thead tr td{text-align: center;}
      	.table-head tr td{text-align: center;}
      </style>
   </head>
   <body>
   		
	    <table cellpadding="2" CELLSPACING="0" BORDER="2" align="center" class="table-top">
	        <TR>
	            <th class="center" ROWSPAN="2"><img src="{{ asset('assets/images/logo.png') }}"></th>
	            <th class="center"> FAKTURA VAT NR (RECHNUNG NR.) </th>
	            <th class="center"> 1/2022 </th>
	        </TR>
	        <TR>
	            <TD>
	               <table>
	                  <TR>
	                     <th class="center">  Miejscowość,data(Ort, Datum) </th>
	                     <th class="center">  Skrzyszów,data of downloading the file </th>
	                  </TR>
	                  <TR>
	                     <TD align="center">  Datasprzedaży / zaliczki  Nr ewid.
	                        (Verkaufsdatum / Vorauszahlungsdatum) 
	                     </TD>
	                     <TD align="center"> date of downloading the file </TD>
	                  </TR>
	               </table>
	            </TD>
	            <TD> 
	            	<table>
	                  <TR >
	                     <th class="center" colspan="2" width="60px">  OrigiNal </th>
	                  </TR>
	                  <TR>
	                     <TD align="center" width="30px"> Nr ewid (Register Nr) </TD>
	                     <TD align="center" width="30px">  </TD>
	                  </TR>
	               </table>
	           	</TD>
	        </TR>
	    </table>

	    <table cellpadding="2" CELLSPACING="0" BORDER="2" align="center" class="table-head">
	    	<tr>
	    		<td rowspan="4"><b>Sprzedawca</b></td>
	    		<td>Work Jackpot Grzegorz</td>
	    		<td rowspan="4"><b>Nabywca (Käufer)</b></td>
	    		<td >PROVIDER'S COMPANY NAME</td>
	    	</tr>
	    	<tr>
	    		<td>Ul. Wspólna 3</td>
	    		<td>PROVIDER'S STREET</td>
	    	</tr>
	    	<tr>
	    		<td>44-348 Skrzyszów</td>
	    		<td>PROVIDER'S ZIP CODE (space) PROVIDER'S CITY</td>
	    	</tr>
	    	<tr>
	    		<td>Polska</td>
	    		<td>PROVIDER'S COUNTRY</td>
	    	</tr>
	    	<tr>
	    		<td><b>Nr NIP (Ust-IdNr.)</b></td>
	    		<td></td>
	    		<td><b>Nr NIP (Ust-IdNr.)</b></td>
	    		<td>PROVIDER'S COMPANY TAX ID NUMBER</td>
	    	</tr>
	    	<tr>
	    		<td><b>Nr rach. bank. (Bk.-Kto. Nr.)</b></td>
	    		<td></td>
	    		<td colspan="2">
	    			<table>
		            	<tr>
		            		<td align="center">Sposób zapłaty (Zahlungsart)</td>
			            	<td align="center">Przelew (Überwe̱i̱sung)</td>
			            	<td align="center">Termin płatności (Zahlungsfrist)</td>
			            	<td align="center">date of downloading the file +14 days</td>
		            	</tr>
	                </table>
	    		</td>
	    	</tr>
	    </table>
		
		<table CELLSPACING="0"  align="center" BORDER="2" class="data-table">
			<thead>
				<tr>
		  			<td><b>Lp(Nr.)</b></td>
		  			<td><b>Nazwa towaru /usługi(Bezeichnung der Ware /Dienstleistung)</b></td>
		  			<td><b>Symbol PKWiU (PKWiU Symbol)</b></td>
		  			<td><b>J.m. (ME)</b></td>
		  			<td><b>Ilość (Menge)</b></td>
		  			<td><b>Cena jednost. netto (Einzelpreis Netto)</b><span>EUR</span></td>
		  			<td><b>Wartość towaru / usługi netto (Nettowert der Waren / Dienstleistungen)</b><span>EUR</span></td>
		  			<td><b>Podatek (MWST)</b><span>EUR</span></td>
		  			<td><b>Wartość towaru / usługi brutto (Bruttowert der Waren / Dienstleistungen)</b><span>EUR</span></td>
		  		</tr>	
	  		</thead>
	  		<tbody>
	  			<tr>
					<td>1</td>
					<td>Prowizja za wynajem pracownika (Provision für die Einstellung einesMitarbeiters)</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="5" rowspan="2"><b>Słownie EUR: (in Worten EUR)</b></td>
					<td>RAZEM (INSGESAMT)</td>
					<td></td>
					<td>X</td>
					<td></td>
				</tr>
				<tr>
					<td>W TYM (EINSCHLIESSLICH)</td>
					<td></td>
					<td>zw(stfr.)</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2" rowspan="5">imię i nazwisko oraz podpis osoby upoważnionej do otrzymania
					faktury (Vor- und Nachname und Unterschrift
					der Person, die zum Empfang der Rechnung berechtigt ist</td>
					<td colspan="4" rowspan="5">podpis i pieczeć imienna osoby uprawnionej do wystawienia faktury
					(Unterschrift und Namensstempel der zur Rechnungsstellung berechtigten
					Person</td>
					<td></td>
					<td>22</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>7</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>3</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>0</td>
					<td></td>
				</tr>
				<tr>
					<td>DO ZAPŁATY (ZU ZAHLEN)</td>
					<td colspan="2"></td>
				</tr>
	  		</tbody>
	  	</table>

 		<table CELLSPACING="0" align="left" border="0">
			
  			<tr><td><p>Dodatkowe informacje</p></td></tr>
  			<tr><td><p>(Zusätzliche Informationen)</p></td></tr>
  			<tr><td><hr></td></tr>
  			<tr><td>1. Numer umowy: (Vertragsnummer) CONTRACT NO</td></tr>
  			<tr><td><hr></td></tr>
  			<tr><td>2. Za miesiąc:  (für den Monat) MOUNTH OF BILL -1</td></tr>
  			<tr><td><hr></td></tr>
  			<tr><td><hr></td></tr>
  			<tr><td><hr></td></tr>
  			<tr><td><hr></td></tr>
	  	</table>

   </body>
</html>