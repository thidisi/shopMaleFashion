<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            [
                "name" => "Áo thun nam",
                "slug" => "Mỗi năm áo thun nam 4MEN lại có những biến hóa khác nhau để phù hợp với xu hướng thời trang đang hiện hành và hiện nay những kiểu áo thun họa tiết, phối chữ rất được các tín đồ thời trang mến mộ hay những chiếc áo thun với kiểu dáng đơn giản, dễ kết hợp cùng nhiều loại thời trang khác nhau cũng rất được lòng phái mạnh.",
                "avatar" => "avatarCategories/uZNWi3HFI77W7Vi5b0hRmZZj55ENu7oCB4wcmkSn.png",
                "status" => "active",
                "major_category_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Áo sơ mi",
                "slug" => "Áo sơ mi nam luôn là trang phục lựa chọn hàng đầu của nhiều chàng trai, bởi sự tiện ích và tính thời trang mà nó mang lại cho người mặc. Tại 4MEN, chúng tôi thường xuyên cập nhật những mẫu áo sơ mi mới từ kiểu dáng trơn, sọc caro đến sơ mi phối họa tiết…, nhằm giúp khách hàng lựa chọn được những sản phẩm đẹp, chất lượng phù hợp với nhu cầu và sở thích của mình một cách dễ dàng nhất.",
                "avatar" => "avatarCategories/w5cNGjfEXgr37FxVKEGmCXl5jvBOl7DQ4R3XViBH.png",
                "status" => "active",
                "major_category_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Quần Jean Nam",
                "slug" => "Lọc danh mục  Sắp xếp: Mặc định Quần jeans nam là trang phục có giá trị và thông dụng nhất trong tủ quần áo. Với những ưu điểm như chắc, bền, đẹp, các sản phẩm làm từ chất liệu jean mang lại cho người mặc, nhất là các chàng trai, vẻ ngoài mạnh mẽ và phong cách. Để chọn được một chiếc quần jeans phù hợp, bạn có thể đến với 4MEN, chúng tôi thường xuyên cập nhật những mẫu quần jean nam đẹp và thời trang nhất từ quần jean skinny, quần jean nam rách cho đến quần jean ống đứng…",
                "avatar" => "avatarCategories/K215GFgRJe9pXGRMmCxFynAjoEExFWJl0mEhZQUZ.jpg",
                "status" => "active",
                "major_category_id" => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Túi đeo chéo",
                "slug" => "Túi đeo chéo",
                "avatar" => "avatarCategories/BcFgscNr7bsBgxcezuzKTI7OSiAZ7pU1iP0sim7Q.png",
                "status" => "active",
                "major_category_id" => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Giày Nam",
                "slug" => "Giày nam tại 4MEN phù hợp với thị hiếu  nhiều đối tượng khách hàng khác nhau. Bạn dễ dàng tìm thấy những đôi giày lười hiện đại, hay những đôi giày thể thao năng động, cho đến giày tây tại văn phòng sang trọng…. Dù là kiểu giày nào chúng tôi vẫn luôn giúp bạn tạo nên những phong cách thời trang ấn tượng nhất. Giày nam tại 4MEN luôn được thiết kế và sản xuất với chất liệu da bò thật 100%, đa dạng kiểu dáng từ lịch lãm, cổ điển đến thời trang, sang trọng",
                "avatar" => "avatarCategories/hH92eltdxkdZ4jz2AEE6Huwc0zinyqZ6QTlk21jT.png",
                "status" => "active",
                "major_category_id" => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
