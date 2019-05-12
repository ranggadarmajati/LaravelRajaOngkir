# Laravel Raja Ongkir (starter, basic, pro)
Package untuk memudahkan penggunaan Servis API Raja Ongkir

## Install Package Composer

#### Untuk install Package ini ada 2 cara :

1. Install via "composer"
```code
$ composer require rdj/rajaongkir "dev-master"
```
2. Tambahkan manual di composer.json

   Step 1
   ```code
   {
      ...
      "require"{ 
           "rdj/rajaongkir" : "dev-master"
      }
   }
   ```
   Step 2
   ```code
   $ composer update
   ```

## Integrasi Laravel

Daftarkan Provider di file config/app.php `config/app.php`:
```code
'providers' => [
	// ...

	Rdj\Rajaongkir\RajaongkirServiceProvider::class,
]
```
Tambahkan alias facade di file yang sama `config/app.php`:
```code
'aliases' => [
	// ...

	'Rajaongkir' => Rdj\Rajaongkir\Facades\Rajaongkir::class,
]
```
Publikasikan file konfigurasi package menggunakan perintah berikut:
```code
$ php artisan vendor:publish
```

## Setting Enviroment (.env)
Edit file `.env` tambahkan code berikut :
```code
RAJAONGKIR_APIKEY=your_api_key_raja_ongkir
RAJAONGKIR_TYPE=your_type_account(e.g:starter or basic or pro)
```
## Cara Penggunaan
Berikut Cara Penggunaan Package ini:

#### - Mengambil data Provinsi
```code
$getData = Rajaongkir::setEndpoint('province')
                    ->setBase(env("RAJAONGKIR_TYPE"))
                    ->setQuery([])
                    ->get();
        
return response()->json( $getData['rajaongkir'] );
```
#### - Mengambil data Provinsi by id
```code
$id = 12;
$getData = Rajaongkir::setEndpoint('province')
                    ->setBase(env("RAJAONGKIR_TYPE"))
                    ->setQuery(['id' => $id])
                    ->get();
        
return response()->json( $getData['rajaongkir'] );
```

#### - Mengambil data Kota
```code
$getData = Rajaongkir::setEndpoint('city')
                    ->setBase(env("RAJAONGKIR_TYPE"))
                    ->setQuery([])
                    ->get();
        
return response()->json( $getData['rajaongkir'] );
```
#### - Mengambil data Kota by id
```code
$id = 12;
$getData = Rajaongkir::setEndpoint('city')
                    ->setBase(env("RAJAONGKIR_TYPE"))
                    ->setQuery(['id' => $id])
                    ->get();
        
return response()->json( $getData['rajaongkir'] );
```
#### - Mengambil data Kecematan by id (Only Account pro)
```code
$id = 12;
$getData = Rajaongkir::setEndpoint('subdistrict')
                    ->setBase(env("RAJAONGKIR_TYPE"))
                    ->setQuery(['id' => $id])
                    ->get();
        
return response()->json( $getData['rajaongkir'] );
```
#### - Mengambil data Biaya Ongkir (Account pro)
```code
$request = [
   "origin" => "501",
   "originType"  => "city",
   "destination" => "574",
   "destinationType" => "subdistrict",
   "weight" => 1700,
   "courier" => "jne"
];
        
$getData = Rajaongkir::setEndpoint('cost')
                    ->setBase(env("RAJAONGKIR_TYPE"))
                    ->setBody($request)
                    ->post();
        
return response()->json( $getData['rajaongkir'] );
```

#### - Mengambil data Biaya Ongkir (Account starter & basic)
```code
$request = [
   "origin" => "501",
   "destination" => "574",
   "weight" => 1700,
   "courier" => "jne"
];
        
$getData = Rajaongkir::setEndpoint('cost')
                    ->setBase(env("RAJAONGKIR_TYPE"))
                    ->setBody($request)
                    ->post();
        
return response()->json( $getData['rajaongkir'] );
```

## Api Raja Ongkir Documentations
Untuk mengetahui selengkapnya tentang API Raja Ongkir silahkan kunjungi: 
* [API Rajaongkir Pro](https://rajaongkir.com/dokumentasi/pro)
* [API Rajaongkir Basic](https://rajaongkir.com/dokumentasi/basic)
* [API Rajaongkir Starter](https://rajaongkir.com/dokumentasi/starter)

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
This Package have license under [MIT License](https://github.com/ranggadarmajati/LaravelRajaOngkir/blob/master/LICENSE)
