<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends CI_Controller {

    public function index()
    {
        $data['rooms'] = array(
            array(
                'id'       => 'a01',
                'code'     => 'A01',
                'name'     => '豪華雙人間',
                'en'       => 'Deluxe Double Room',
                'style'    => '波希米亞風格',
                'guests'   => 2,
                'extra'    => 4,
                'layout'   => 'full',
                'desc'     => '編織、藤編與暖色織品堆疊出隨性的度假感。空間寬敞，可加人加床，適合一家人或三五好友一起入住。',
                'features' => array('tub', 'balcony', 'coffee'),
                'prices'   => array(5800, 6600, 7200, 8800),
                'images'   => array(
                    '/images/rooms/a01-1.jpg',
                    '/images/rooms/a01-2.jpg',
                    '/images/rooms/a01-3.jpg',
                    '/images/rooms/a01-4.jpg',
                ),
            ),
            array(
                'id'       => 'b01',
                'code'     => 'B01',
                'name'     => '雙人套房',
                'en'       => 'Double Suite',
                'style'    => '日式北歐風',
                'guests'   => 2,
                'extra'    => 1,
                'layout'   => 'half',
                'desc'     => '淺木色與柔白牆面，簡單乾淨。泡個澡、到陽台吹吹風，安靜地過完一晚。',
                'features' => array('tub', 'balcony', 'coffee'),
                'prices'   => array(3800, 4200, 4800, 5600),
                'images'   => array(
                    '/images/rooms/b01-1.jpg',
                    '/images/rooms/b01-2.jpg',
                    '/images/rooms/b01-3.jpg',
                    '/images/rooms/b01-4.jpg',
                ),
            ),
            array(
                'id'       => 'b02',
                'code'     => 'B02',
                'name'     => '四人套房',
                'en'       => 'Quad Suite',
                'style'    => '峇里島渡假風',
                'guests'   => 4,
                'extra'    => 2,
                'layout'   => 'half',
                'desc'     => '深色木作搭配綠意與藤編燈飾，像是把南島假期搬進房間，適合親子同遊。',
                'features' => array('tub', 'balcony', 'coffee'),
                'prices'   => array(6800, 7600, 8400, 9600),
                'images'   => array(
                    '/images/rooms/b02-1.jpg',
                    '/images/rooms/b02-2.jpg',
                    '/images/rooms/b02-3.jpg',
                    '/images/rooms/b02-4.jpg',
                ),
            ),
            array(
                'id'       => 'c02',
                'code'     => 'C02',
                'name'     => '四人套房',
                'en'       => 'Quad Suite',
                'style'    => '日式侘寂風',
                'guests'   => 4,
                'extra'    => 1,
                'layout'   => 'full',
                'desc'     => '土牆質感、低彩度的家具與自然光，留白的空間讓心慢下來，是全家人一起好好休息的地方。',
                'features' => array('tub', 'balcony', 'coffee'),
                'prices'   => array(6800, 7600, 8400, 9600),
                'images'   => array(
                    '/images/rooms/c02-1.jpg',
                    '/images/rooms/c02-2.jpg',
                    '/images/rooms/c02-3.jpg',
                    '/images/rooms/c02-4.jpg',
                ),
            ),
            array(
                'id'       => 'd01',
                'code'     => 'D01',
                'name'     => '雙人套房',
                'en'       => 'Double Suite',
                'style'    => '南洋渡假風',
                'guests'   => 2,
                'extra'    => 1,
                'layout'   => 'half',
                'desc'     => '暖陽色調與植栽點綴，帶著一點熱帶的慵懶。兩個人的小旅行，剛剛好。',
                'features' => array('tub', 'balcony', 'coffee'),
                'prices'   => array(3980, 4580, 4980, 5800),
                'images'   => array(
                    '/images/rooms/d01-1.jpg',
                    '/images/rooms/d01-2.jpg',
                    '/images/rooms/d01-3.jpg',
                    '/images/rooms/d01-4.jpg',
                ),
            ),
            array(
                'id'       => 'c01',
                'code'     => 'C01',
                'name'     => '雙人套房',
                'en'       => 'Double Suite',
                'style'    => '日式北歐風',
                'guests'   => 2,
                'extra'    => 1,
                'layout'   => 'half',
                'desc'     => '原木家具與柔和光線，日式的簡約遇上北歐的溫暖。放慢腳步，給兩個人一段舒服的時光。',
                'features' => array('tub', 'balcony', 'coffee'),
                'prices'   => array(3800, 4200, 4800, 5600),
                'images'   => array(
                    '/images/rooms/c01-1.jpg',
                    '/images/rooms/c01-2.jpg',
                    '/images/rooms/c01-3.jpg',
                    '/images/rooms/c01-4.jpg',
                ),
            ),
        );

        $data['features'] = array(
            'tub'     => '泡澡浴缸',
            'balcony' => '專屬陽台',
            'coffee'  => '膠囊咖啡',
        );

        $data['facilities'] = array('冷暖氣機', '液晶電視', '吹風機', '浴巾', '沐浴用品', 'WIFI上網', '獨立衛浴', '泡澡浴缸', '免費飲品', '專屬陽台');

        $this->load->view('room/index', $data);
    }
}
