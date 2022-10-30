<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Province::insert([
            [
                "name" => "Hà Nội",
                "slug" => "ha-noi",
                "id" => "01"
            ],
            [
                "name" => "Hà Giang",
                "slug" => "ha-giang",
                "id" => "02"
            ],
            [
                "name" => "Cao Bằng",
                "slug" => "cao-bang",
                "id" => "04"
            ],
            [
                "name" => "Bắc Kạn",
                "slug" => "bac-kan",
                "id" => "06"
            ],
            [
                "name" => "Tuyên Quang",
                "slug" => "tuyen-quang",
                "id" => "08"
            ],
            [
                "name" => "Lào Cai",
                "slug" => "lao-cai",
                "id" => "10"
            ],
            [
                "name" => "Điện Biên",
                "slug" => "dien-bien",
                "id" => "11"
            ],
            [
                "name" => "Lai Châu",
                "slug" => "lai-chau",
                "id" => "12"
            ],
            [
                "name" => "Sơn La",
                "slug" => "son-la",
                "id" => "14"
            ],
            [
                "name" => "Yên Bái",
                "slug" => "yen-bai",
                "id" => "15"
            ],
            [
                "name" => "Hoà Bình",
                "slug" => "hoa-binh",
                "id" => "17"
            ],
            [
                "name" => "Thái Nguyên",
                "slug" => "thai-nguyen",
                "id" => "19"
            ],
            [
                "name" => "Lạng Sơn",
                "slug" => "lang-son",
                "id" => "20"
            ],
            [
                "name" => "Quảng Ninh",
                "slug" => "quang-ninh",
                "id" => "22"
            ],
            [
                "name" => "Bắc Giang",
                "slug" => "bac-giang",
                "id" => "24"
            ],
            [
                "name" => "Phú Thọ",
                "slug" => "phu-tho",
                "id" => "25"
            ],
            [
                "name" => "Vĩnh Phúc",
                "slug" => "vinh-phuc",
                "id" => "26"
            ],
            [
                "name" => "Bắc Ninh",
                "slug" => "bac-ninh",
                "id" => "27"
            ],
            [
                "name" => "Hải Dương",
                "slug" => "hai-duong",
                "id" => "30"
            ],
            [
                "name" => "Hải Phòng",
                "slug" => "hai-phong",
                "id" => "31"
            ],
            [
                "name" => "Hưng Yên",
                "slug" => "hung-yen",
                "id" => "33"
            ],
            [
                "name" => "Thái Bình",
                "slug" => "thai-binh",
                "id" => "34"
            ],
            [
                "name" => "Hà Nam",
                "slug" => "ha-nam",
                "id" => "35"
            ],
            [
                "name" => "Nam Định",
                "slug" => "nam-dinh",
                "id" => "36"
            ],
            [
                "name" => "Ninh Bình",
                "slug" => "ninh-binh",
                "id" => "37"
            ],
            [
                "name" => "Thanh Hóa",
                "slug" => "thanh-hoa",
                "id" => "38"
            ],
            [
                "name" => "Nghệ An",
                "slug" => "nghe-an",
                "id" => "40"
            ],
            [
                "name" => "Hà Tĩnh",
                "slug" => "ha-tinh",
                "id" => "42"
            ],
            [
                "name" => "Quảng Bình",
                "slug" => "quang-binh",
                "id" => "44"
            ],
            [
                "name" => "Quảng Trị",
                "slug" => "quang-tri",
                "id" => "45"
            ],
            [
                "name" => "Thừa Thiên Huế",
                "slug" => "thua-thien-hue",
                "id" => "46"
            ],
            [
                "name" => "Đà Nẵng",
                "slug" => "da-nang",
                "id" => "48"
            ],
            [
                "name" => "Quảng Nam",
                "slug" => "quang-nam",
                "id" => "49"
            ],
            [
                "name" => "Quảng Ngãi",
                "slug" => "quang-ngai",
                "id" => "51"
            ],
            [
                "name" => "Bình Định",
                "slug" => "binh-dinh",
                "id" => "52"
            ],
            [
                "name" => "Phú Yên",
                "slug" => "phu-yen",
                "id" => "54"
            ],
            [
                "name" => "Khánh Hòa",
                "slug" => "khanh-hoa",
                "id" => "56"
            ],
            [
                "name" => "Ninh Thuận",
                "slug" => "ninh-thuan",
                "id" => "58"
            ],
            [
                "name" => "Bình Thuận",
                "slug" => "binh-thuan",
                "id" => "60"
            ],
            [
                "name" => "Kon Tum",
                "slug" => "kon-tum",
                "id" => "62"
            ],
            [
                "name" => "Gia Lai",
                "slug" => "gia-lai",
                "id" => "64"
            ],
            [
                "name" => "Đắk Lắk",
                "slug" => "dak-lak",
                "id" => "66"
            ],
            [
                "name" => "Đắk Nông",
                "slug" => "dak-nong",
                "id" => "67"
            ],
            [
                "name" => "Lâm Đồng",
                "slug" => "lam-dong",
                "id" => "68"
            ],
            [
                "name" => "Bình Phước",
                "slug" => "binh-phuoc",
                "id" => "70"
            ],
            [
                "name" => "Tây Ninh",
                "slug" => "tay-ninh",
                "id" => "72"
            ],
            [
                "name" => "Bình Dương",
                "slug" => "binh-duong",
                "id" => "74"
            ],
            [
                "name" => "Đồng Nai",
                "slug" => "dong-nai",
                "id" => "75"
            ],
            [
                "name" => "Bà Rịa - Vũng Tàu",
                "slug" => "ba-ria-vung-tau",
                "id" => "77"
            ],
            [
                "name" => "Hồ Chí Minh",
                "slug" => "ho-chi-minh",
                "id" => "79"
            ],
            [
                "name" => "Long An",
                "slug" => "long-an",
                "id" => "80"
            ],
            [
                "name" => "Tiền Giang",
                "slug" => "tien-giang",
                "id" => "82"
            ],
            [
                "name" => "Bến Tre",
                "slug" => "ben-tre",
                "id" => "83"
            ],
            [
                "name" => "Trà Vinh",
                "slug" => "tra-vinh",
                "id" => "84"
            ],
            [
                "name" => "Vĩnh Long",
                "slug" => "vinh-long",
                "id" => "86"
            ],
            [
                "name" => "Đồng Tháp",
                "slug" => "dong-thap",
                "id" => "87"
            ],
            [
                "name" => "An Giang",
                "slug" => "an-giang",
                "id" => "89"
            ],
            [
                "name" => "Kiên Giang",
                "slug" => "kien-giang",
                "id" => "91"
            ],
            [
                "name" => "Cần Thơ",
                "slug" => "can-tho",
                "id" => "92"
            ],
            [
                "name" => "Hậu Giang",
                "slug" => "hau-giang",
                "id" => "93"
            ],
            [
                "name" => "Sóc Trăng",
                "slug" => "soc-trang",
                "id" => "94"
            ],
            [
                "name" => "Bạc Liêu",
                "slug" => "bac-lieu",
                "id" => "95"
            ],
            [
                "name" => "Cà Mau",
                "slug" => "ca-mau",
                "id" => "96"
            ],
        ]);
    }
}
