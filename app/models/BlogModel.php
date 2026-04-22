<?php
class BlogModel
{
    public function getAll()
    {
        return [
            [
                'id' => 1,
                'title' => 'Building a Home with the Earth',
                'excerpt' => 'Cách vật liệu bền vững tạo nên không gian sống hiện đại và có chiều sâu.',
                'image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Sustainability',
            ],
            [
                'id' => 2,
                'title' => 'The Future of Conscious Interiors',
                'excerpt' => 'Thiết kế nội thất xanh không chỉ là xu hướng, mà là tiêu chuẩn mới.',
                'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Interiors',
            ],
            [
                'id' => 3,
                'title' => 'Small Rituals for a Greener Home',
                'excerpt' => 'Một vài thay đổi nhỏ trong sinh hoạt hằng ngày có thể tạo khác biệt lớn cho môi trường.',
                'image' => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Lifestyle',
            ],
        ];
    }

    public function getById($id)
    {
        $id = (int)$id;

        foreach ($this->getAll() as $blog) {
            if ((int)$blog['id'] === $id) {
                return $blog;
            }
        }

        return null;
    }
}