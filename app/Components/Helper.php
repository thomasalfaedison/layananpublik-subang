<?php

namespace App\Components;

use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeImmutable;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class Helper
{
    public static function url($array)
    {
        $i = 1;
        $output = '';
        foreach ($array as $key => $value) {
            if ($i == 1) {
                $output .= $value;
            } elseif ($i == 2) {
                $output .= '?' . $key . '=' . $value;
            } else {
                $output .= '&' . $key . '=' . $value;
            }
            $i++;
        }

        return $output;
    }

	public static function rp($jumlah, $null=null, $decimal = 0)
	{
		if($jumlah==null) {
			return $null;
		} elseif(is_integer($jumlah)) {
			return number_format($jumlah,$decimal,',','.');
		} else {
			return number_format($jumlah,$decimal,',','.');
		}
	}

    public static function getTanggalToDisplay($tanggal)
    {
        $datetime = \DateTime::createFromFormat('Y-m-d', $tanggal);

        if($datetime == false) {
            return null;
        }

        return $datetime->format('d-m-Y');
    }

	public static function getTanggalToSave($tanggal)
    {
        $datetime = \DateTime::createFromFormat('d-m-Y', $tanggal);

        if($datetime == false) {
            return false;
        }

        return $datetime->format('Y-m-d');
    }

	public static function getHariByInteger($int)
	{
		if($int==1) return "Senin";
		if($int==2) return "Selasa";
		if($int==3) return "Rabu";
		if($int==4) return "Kamis";
		if($int==5) return "Jumat";
		if($int==6) return "Sabtu";
		if($int==7) return "Minggu";
		if($int==8) return "Hari Libur";
	}

	public static function getJamMenit($waktu)
	{
		$date = date_create($waktu);
		return $date->format('H:i');
	}

	public static function getJamMenitDetik($waktu)
	{
		$date = date_create($waktu);
		return $date->format('H:i:s');
	}

	public static function getSelisihWaktu($time1=null,$time2=null)
	{
		if($time1==null) {
			return null;
		}

		if($time2==null) {
			date_default_timezone_set('Asia/Jakarta');
			$time2 = date('Y-m-d H:i:s');
		}

		$time1 = date_create($time1);
        $time2 = date_create($time2);
        $dateDiff = date_diff($time1,$time2);

        $bulan = $dateDiff->m;
        $hari = $dateDiff->d;
        $jam = $dateDiff->h;
        $menit = $dateDiff->i;
        $detik = $dateDiff->s;

        if($bulan!=0) {
        	return $bulan.' Bulan';
        }

        if($hari!=0) {
        	return $hari.' Hari';
        }

        if($jam!=0) {
        	return $jam.' Jam';
        }

        if($menit!=0) {
        	return $menit.' Menit';
        }

        if($detik!=0) {
        	return $detik.' Detik';
        }

        return null;
	}

	public static function getTanggalSingkat($tanggal)
	{
        if($tanggal=='9999-12-31') {
            return '';
        }

		if($tanggal==null)
			return null;

		if($tanggal=='0000-00-00')
			return null;

		$time = strtotime($tanggal);

		return date('j',$time).' '.Helper::getBulanSingkat(date('m',$time)).' '.date('Y',$time);
	}

	public static function getIconRemove($status=null,$tooltip=null)
	{
		if($status==1)
		{
			return "<i class='fa fa-remove' data-toggle='tooltip' title='".$tooltip."'></i>";
		}

	}

	public static function getIconExcel($status=null,$tooltip=null)
	{
		if($status==1)
		{
			return "x";
		}

	}

	public static function getTanggal($tanggal)
	{
		if($tanggal==null)
			return null;

		if($tanggal=='0000-00-00')
			return null;

		$time = strtotime($tanggal);

		return date('j',$time).' '.Helper::getBulanLengkap(date('m',$time)).' '.date('Y',$time);
	}

	public static function getHari($tanggal)
	{
		$time = strtotime($tanggal);

		$h = date('N',$time);

		if($h == '1') $hari = 'Senin';
		if($h == '2') $hari = 'Selasa';
		if($h == '3') $hari = 'Rabu';
		if($h == '4') $hari = 'Kamis';
		if($h == '5') $hari = 'Jumat';
		if($h == '6') $hari = 'Sabtu';
		if($h == '7') $hari = 'Minggu';

		return $hari;
	}


	public static function getHariTanggal($tanggal)
	{
		if($tanggal==null)
			return null;

		if($tanggal=='0000-00-00')
			return null;

		$time = strtotime($tanggal);

		$h = date('N',$time);

		if($h == '1') $hari = 'Senin';
		if($h == '2') $hari = 'Selasa';
		if($h == '3') $hari = 'Rabu';
		if($h == '4') $hari = 'Kamis';
		if($h == '5') $hari = 'Jumat';
		if($h == '6') $hari = 'Sabtu';
		if($h == '7') $hari = 'Minggu';

		return $hari.', '.date('j',$time).' '.Helper::getBulanLengkap(date('m',$time)).' '.date('Y',$time);
	}

	public static function getBulanSingkat($i)
	{
		$bulan = '';

		if(strlen($i)==1) $i = '0'.$i;

		if($i=='01') $bulan = 'Jan';
		if($i=='02') $bulan = 'Feb';
		if($i=='03') $bulan = 'Mar';
		if($i=='04') $bulan = 'Apr';
		if($i=='05') $bulan = 'Mei';
		if($i=='06') $bulan = 'Jun';
		if($i=='07') $bulan = 'Jul';
		if($i=='08') $bulan = 'Agt';
		if($i=='09') $bulan = 'Sep';
		if($i=='10') $bulan = 'Okt';
		if($i=='11') $bulan = 'Nov';
		if($i=='12') $bulan = 'Des';

		return $bulan;

	}

	public static function getBulanLengkap($i)
	{
		$bulan = '';

		if(strlen($i)==1) $i = '0'.$i;

		if($i=='01') $bulan = 'Januari';
		if($i=='02') $bulan = 'Februari';
		if($i=='03') $bulan = 'Maret';
		if($i=='04') $bulan = 'April';
		if($i=='05') $bulan = 'Mei';
		if($i=='06') $bulan = 'Juni';
		if($i=='07') $bulan = 'Juli';
		if($i=='08') $bulan = 'Agustus';
		if($i=='09') $bulan = 'September';
		if($i=='10') $bulan = 'Oktober';
		if($i=='11') $bulan = 'November';
		if($i=='12') $bulan = 'Desember';

		return $bulan;

	}

	public static function getWaktuWIB($waktu)
	{
		if($waktu == '')
			return null;
		else {
		$time = strtotime($waktu);

		$h = date('N',$time);

		if($h == '1') $hari = 'Senin';
		if($h == '2') $hari = 'Selasa';
		if($h == '3') $hari = 'Rabu';
		if($h == '4') $hari = 'Kamis';
		if($h == '5') $hari = 'Jumat';
		if($h == '6') $hari = 'Sabtu';
		if($h == '7') $hari = 'Minggu';


		$tgl = date('j',$time);

		$h = date('n',$time);

		if($h == '1') $bulan = 'Januari';
		if($h == '2') $bulan = 'Februari';
		if($h == '3') $bulan = 'Maret';
		if($h == '4') $bulan = 'April';
		if($h == '5') $bulan = 'Mei';
		if($h == '6') $bulan = 'Juni';
		if($h == '7') $bulan = 'Juli';
		if($h == '8') $bulan = 'Agustus';
		if($h == '9') $bulan = 'September';
		if($h == '10') $bulan = 'Oktober';
		if($h == '11') $bulan = 'November';
		if($h == '12') $bulan = 'Desember';

		$tahun  = date('Y',$time);

		$pukul = date('H:i:s',$time);

		$output = $hari.', '.$tgl.' '.$bulan.' '.$tahun.' | '.$pukul.' WIB';

		return $output;
		}

	}

	public static function getWaktu($waktu,$wib=false)
	{
		$time = strtotime($waktu);

		$pukul = date('H:i',$time);

		if ($wib)
			$pukul .= " WIB";

		return $pukul;
	}

	public static function getListBulan($lengkap = true)
	{
		$bulan = [];

		for($i=1;$i<=12;$i++) {
			$bulan[$i] = Helper::getBulanLengkap($i);
		}

		return $bulan;
	}

	public static function getListBulanSingkat($lengkap = true)
	{
		$bulan = [];

		for($i=1;$i<=12;$i++) {
			$bulan[$i] = Helper::getBulanSingkat($i);
		}

		return $bulan;
	}

    public static function getTanggalDanJam($tanggal)
    {
        if ($tanggal !== '' AND $tanggal !== null) {
            return static::getTanggal($tanggal).', '.static::getJamPadaYmdHis($tanggal);
        }

        return '-';
    }

    private static function getJamPadaYmdHis($tanggal)
    {
         $dateTime = new \DateTime($tanggal);

        if ($dateTime->format('H:i:s') !== null) {
            return $dateTime->format('H:i');
        }

        return '';
	}

	public static function getTanggalAkhirPadaBulan($bulan)
	{
		$tahun = Session::getTahun();
		$bulan = $bulan;

		if(strlen($bulan)==1) $bulan = '0'.$bulan;

		$awalTanggal = "$tahun-$bulan-1";

		$tanggal = strtotime($awalTanggal);

		$akhirTanggal = strtotime(date("Y-m-t", $tanggal));

		$getAkhirTanggal = date("t", $akhirTanggal);

		return $getAkhirTanggal;
	}

    public function getBulanListFilter()
	{
		$bulan = [];
		$i = 1;
		while ($i <= 12) {
			$i = sprintf('%02d', $i);
			$bulan[$i] = self::getBulanLengkap($i);
			$i++;
		}

		return $bulan;
	}

	public function getTahun($tanggal)
	{
		$data = new \DateTime($tanggal);

		return $data->format('Y');
	}

	public static function getFormatRupiahExcel()
	{
		return '[$Rp-421]#,##0.00';
	}

	public static function getFormatRupiahExcelTanpaRp()
	{
		return '#,##0.00';
	}

	public static function getTriwulan($i)
	{
		if (in_array($i, [1,2,3,4,'1','2','3','4'])) {
			if ($i == 1) {
				return self::getBulanLengkap(1) . ' - ' . self::getBulanLengkap(3);
			} elseif ($i == 2) {
				return self::getBulanLengkap(4) . ' - ' . self::getBulanLengkap(6);
			} elseif ($i == 3) {
				return self::getBulanLengkap(7) . ' - ' . self::getBulanLengkap(9);
			} elseif ($i == 4) {
				return self::getBulanLengkap(10) . ' - ' . self::getBulanLengkap(12);
			}
		} else {
			return null;
		}

	}

    public static function getTerbilang($rp,$tri=0)
    {
        $ones = array(
            "",
            " satu",
            " dua",
            " tiga",
            " empat",
            " lima",
            " enam",
            " tujuh",
            " delapan",
            " sembilan",
            " sepuluh",
            " sebelas",
            " dua belas",
            " tiga belas",
            " empat belas",
            " lima belas",
            " enam belas",
            " tujuh belas",
            " delapan belas",
            " sembilan belas"
        );

        $tens = array(
            "",
            "",
            " dua puluh",
            " tiga puluh",
            " empat puluh",
            " lima puluh",
            " enam puluh",
            " tujuh puluh",
            " delapan puluh",
            " sembilan puluh"
        );

        $triplets = array(
            "",
            " ribu",
            " juta",
            " miliar",
            " triliun",
        );

        // chunk the number, ...rxyy
        $r = (int) ($rp / 1000);
        $x = ($rp / 100) % 10;
        $y = $rp % 100;

        // init the output string
        $str = "";

        // do hundreds
        if ($x > 0)
        {
            if($x==1)
                $str =  " seratus";
            else
                $str = $ones[$x] . " ratus";
        }

        // do ones and tens
        if ($y < 20)
            $str .= $ones[$y];
        else
            $str .= $tens[(int) ($y / 10)] . $ones[$y % 10];

        // add triplet modifier only if there
        // is some output to be modified...
        if ($str != "")
            $str .= $triplets[$tri];

        // continue recursing?
        if ($r > 0)
            return Helper::getTerbilang($r, $tri+1).$str;
        else
            return $str;
    }

	public function isGeoValid($type, $value)
	{
	    $pattern = ($type == 'latitude')
	        ? '/^(\+|-)?(?:90(?:(?:\.0{1,8})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,8})?))$/'
	        : '/^(\+|-)?(?:180(?:(?:\.0{1,8})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,8})?))$/';

	    if (preg_match($pattern, $value)) {
	        return true;
	    } else {
	    	return false;
	    }
	}

	public function convert($center, $radius, $numberOfSegments = 360)
	{
	    $n = $numberOfSegments;
	    $flatCoordinates = [];
	    $coordinates = [];
	    for ($i = 0; $i < $n; $i++) {
	        $bearing = 2 * M_PI * $i / $n;
	        $flatCoordinates[] = self::offset($center, $radius, $bearing);
	    }
	    $flatCoordinates[] = $flatCoordinates[0];

	    return $flatCoordinates;
	    /*
	    	hasil adalah $flatCoordinates[0] = longitude
	    	hasil adalah $flatCoordinates[1] = latitude
	     */
	}

	public function offset($c1, $distance, $bearing) {
	    $lat1 = deg2rad($c1[0]);
	    $lon1 = deg2rad($c1[1]);
	    $dByR = $distance/6378137; // convert dist to angular distance in radians

	    $lat = asin(
	        sin($lat1) * cos($dByR) +
	            cos($lat1) * sin($dByR) * cos($bearing)
	    );
	    $lon = $lon1 + atan2(
	        sin($bearing) * sin($dByR) * cos($lat1),
	        cos($dByR) - sin($lat1) * sin($lat)
	    );
	    $lon = fmod(
	        $lon + 3 * M_PI,
	        2 * M_PI
	    ) - M_PI;
	    return [rad2deg($lon), rad2deg($lat)];
	}

	public static function getTanggalTanpaTahun($tanggal=null)
	{
		if($tanggal == null) {
			return null;
		}

		if($tanggal == '0000-00-00') {
			return null;
		}

		$datetime = \DateTime::createFromFormat('Y-m-d', $tanggal);

		$tanggal = $datetime->format('d/m');

		return $tanggal;
	}

	public static function chr($char,$append = null)
    {
        if($char > 90) {
            if ($append == null) {
                $append = 64;
            }

            return self::chr(($char - 26), ++$append);
        } else {
            if ($append !== null) {
                $append = chr($append);
            }

            return $append . chr($char);
        }
    }

    public static function persen(?float $atas, ?float $bawah, $decimals=1)
    {
        if($bawah==0) {
            return 0;
        }

        return round($atas/$bawah*100, $decimals);

    }

    /**
     * 
     * @param array|string $routes
     * @param string $output
     * @return string
     */
    public static function isMenuActive($routes, $output = 'active')
	{
		$currentPath = Request::path(); // tanpa query string
		$fullUrl = Request::fullUrl();  // termasuk query string

		foreach ((array) $routes as $route) {
			// Jika route berupa full URL (mengandung `?`), cocokkan dengan fullUrl
			if (Str::contains($route, '?')) {
				if ($fullUrl === url($route)) {
					return $output;
				}
			} else {
				// Cek wildcard atau path biasa
				if (Request::is($route)) {
					return $output;
				}
			}
		}

		return '';
	}

    /**
     * 
     * @param array|string $routes
     * @return string
     */
    public static function isMenuOpen($routes)
    {
        return self::isMenuActive($routes, 'menu-open');
    }

	public static function potongText($text, $limit = 100) {
		return strlen($text) > $limit
			? substr($text, 0, $limit) . '...'
			: $text;
	}

	public static function wrapTextExcel(?string $text)
	{
		$cleanText = strip_tags(str_replace(['<li>', '</li>'], ['', "\n"], $text));
		$decodedText = html_entity_decode($cleanText);

		return $decodedText;
	}

	public static function getTanggalDiMingguIni(int $hariKe): ?string
	{
		if ($hariKe < 1 || $hariKe > 7) {
			return null; // input tidak valid
		}

		// Ambil Senin minggu ini sebagai patokan awal
		$senin = new DateTimeImmutable('monday this week');

		// Tambahkan offset hari (0 untuk Senin, 1 untuk Selasa, dst)
		return $senin->modify('+' . ($hariKe - 1) . ' days')->format('Y-m-d');
	}
	
	public static function getTanggalDiBulanIni(int $hari): ?string
	{
		$bulanIni = date('m');
		$tahunIni = date('Y');

		// Cek apakah tanggal valid
		if (checkdate($bulanIni, $hari, $tahunIni)) {
			return date("Y-m-d", strtotime("$tahunIni-$bulanIni-$hari"));
		}

		return null;
	}

}
