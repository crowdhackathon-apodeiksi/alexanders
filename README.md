# Alex²
## Hackathon #apodeiksi Athens First Prize

### Front End
This a cross platform mobile application build with Ionic.

Features:
* Barcode Scan
* OCR BETA
* Insert manual receipts
* Categorise receipts
* List receipts
* Receive offer
* Syncronize data between all devices!!

### Back End
All data is stored to a server build with Laravel 5.

The application provides anonymous open data using REST api.

Authentication is accomplished using JSON Web Token.

There are 3 types of users:
* User
* Business Account
* Administrator

User features:
* View receipts
* View Categories

Business Account:
* View receipts related via VAT number
* Create offer
* View offers

Admin Account:
* View all receipts
* View all categories
* View all offers
