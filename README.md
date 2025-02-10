# Kafelere Özel Menü Sistemi - Yol Haritası (Özet)

## 🚀 Proje Kurulumu
- Laravel 11, Vue 3, Tailwind CSS, Vue Router, Pinia ve Axios eklendi.

## 👤 Kullanıcı Yönetimi
-`User` modeli oluşturuldu,
 - - Kullanıcı kayıt işlemi Blade ile gerçekleştiriliyor.
 - - giriş yapan kullanıcı API ile güncelleme yapabiliyor.

## 📂 Kategori Yönetimi
- `Category` modeli oluşturuldu, sadece giriş yapmış kullanıcılar kendi kategorilerini yönetebilir.
- Kategori CRUD işlemleri tamamlandı, API testleri yapıldı.

## 🍽️ Ürün Yönetimi
- `Product` modeli oluşturuldu, çoktan-çoğa kategori ilişkisi (`category_product` pivot tablosu) eklendi.
- Ürün CRUD işlemleri tamamlandı, kullanıcılar sadece kendi kategorilerine ürün ekleyebilir.

## 🎛️ Admin Paneli
- Vue.js ile admin paneli geliştirildi.
- API entegrasyonu Axios ile yapıldı, Pinia ile state yönetimi sağlandı.
- Kategoriler ve ürünler için yönetim ekranları oluşturuldu.

## 🌐 Müşteri Tarafı
- Blade ile müşteri arayüzü geliştirildi.
- Kafe menüleri ve ürün sayfaları dinamik olarak oluşturuldu.

## ✅ Son Dokunuşlar
- Resim yükleme ve saklama ayarlandı.
- Hata yönetimi ve form doğrulama (validation) iyileştirildi.
- Performans optimizasyonları yapıldı, proje deploy edilmeye hazır.  
