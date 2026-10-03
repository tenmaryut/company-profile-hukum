<?php

namespace Database\Seeders;

use App\Enums\ConsultationStatus;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ConsultationRequest;
use App\Models\Faq;
use App\Models\PageContent;
use App\Models\PracticeArea;
use App\Models\TeamMember;
use App\Support\ContentLibrary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * Isi demo situs dari database/content. Dipanggil saat instalasi dan tiap malam oleh demo:reset.
 */
class DemoContentSeeder extends Seeder
{
    use WithoutModelEvents;

    public const CATEGORIES = [
        'pidana' => ['Pidana', 'KUHP Nasional, KUHAP baru, dan hak-hak dalam proses pidana.'],
        'perdata' => ['Perdata', 'Perjanjian, wanprestasi, dan sengketa keperdataan.'],
        'ketenagakerjaan' => ['Ketenagakerjaan', 'Hubungan kerja dan penyelesaian perselisihan hubungan industrial.'],
        'data-pribadi' => ['Data Pribadi', 'Hak subjek data dan kewajiban pengendali menurut UU Pelindungan Data Pribadi.'],
        'bantuan-hukum' => ['Bantuan Hukum', 'Akses keadilan dan bantuan hukum cuma-cuma.'],
    ];

    /** Avatar ilustrasi per anggota tim fiktif (lihat TeamMember::AVATAR_VARIANTS). */
    public const AVATARS = [
        'rani-paramitha' => 3,
        'dimas-ardiansyah' => 1,
        'sekar-ayuningtyas' => 2,
        'yohanes-lumban-batu' => 6,
        'nadia-kusumawardani' => 7,
    ];

    /** Tanggal terbit tetap (artikel pertama paling baru) supaya hasil reset selalu sama. */
    public const PUBLISHED_DATES = ['2026-09-29 09:00', '2026-09-22 09:00', '2026-09-15 09:00', '2026-09-08 09:00', '2026-09-01 09:00', '2026-08-25 09:00', '2026-08-18 09:00', '2026-08-11 09:00'];

    public function run(): void
    {
        $content = new ContentLibrary;

        $categories = collect(self::CATEGORIES)->map(fn (array $category, string $slug) => ArticleCategory::create([
            'name' => $category[0],
            'slug' => $slug,
            'description' => $category[1],
            'sort_order' => array_search($slug, array_keys(self::CATEGORIES), true) + 1,
        ]));

        foreach ($content->practiceAreas() as $i => $area) {
            PracticeArea::create([...$area, 'sort_order' => $i + 1, 'is_published' => true]);
        }

        $team = collect($content->team())->mapWithKeys(fn (array $member, int $i) => [
            $member['slug'] => TeamMember::create([
                ...$member,
                'avatar_variant' => self::AVATARS[$member['slug']] ?? ($i % 8) + 1,
                'sort_order' => $i + 1,
                'is_published' => true,
            ]),
        ]);

        $disk = Storage::disk('public');

        foreach ($content->articles() as $i => ['meta' => $meta, 'body' => $body]) {
            $coverPath = null;

            if ($source = $content->coverPath($meta['slug'])) {
                $coverPath = 'articles/'.$meta['slug'].'.webp';
                $disk->put($coverPath, (string) file_get_contents($source), 'public');
            }

            Article::create([
                'article_category_id' => $categories->get($meta['category'])?->id ?? throw new \RuntimeException("Kategori {$meta['category']} tidak dikenal."),
                'team_member_id' => $team->get($meta['author'] ?? '')?->id,
                'title' => $meta['title'],
                'slug' => $meta['slug'],
                'excerpt' => $meta['excerpt'],
                'body' => $body,
                'cover_path' => $coverPath,
                'cover_alt' => $meta['cover_alt'] ?? null,
                'published_at' => Carbon::parse(self::PUBLISHED_DATES[$i] ?? '2026-08-01 09:00', 'Asia/Jakarta'),
            ]);
        }

        foreach ($content->faqs() as $i => $faq) {
            Faq::create([...$faq, 'sort_order' => $i + 1, 'is_published' => true]);
        }

        foreach ([
            'profil' => $content->profile(),
            'etika' => $content->ethics(),
            'privasi' => $content->privacy(),
        ] as $key => $body) {
            PageContent::create(['key' => $key, 'title' => PageContent::KEYS[$key], 'body' => $body]);
        }

        $this->sampleRequests();
    }

    /** Contoh permintaan konsultasi (data rekaan, ditandai is_sample) supaya panel demo tidak kosong. */
    protected function sampleRequests(): void
    {
        $areas = PracticeArea::query()->pluck('id', 'slug');

        $samples = [
            ['Contoh: Andi Pratama', 'andi@contoh.example', $areas->first(), 'Data contoh. Saya membeli barang lewat perjanjian tertulis, tetapi barang tidak kunjung dikirim setelah dibayar. Apa langkah yang bisa saya tempuh?', ConsultationStatus::Baru, 3],
            ['Contoh: Siti Rahma', 'siti@contoh.example', $areas->skip(2)->first(), 'Data contoh. Kontrak kerja saya diputus sepihak dan pesangon belum dibayar. Bagaimana prosedur penyelesaiannya?', ConsultationStatus::Ditinjau, 20],
            ['Contoh: CV Maju Bersama', 'admin@majubersama.example', $areas->skip(3)->first(), 'Data contoh. Usaha kami menyimpan data pelanggan. Kewajiban apa saja yang perlu kami penuhi?', ConsultationStatus::Dihubungi, 30],
        ];

        foreach ($samples as [$name, $email, $areaId, $message, $status, $hoursAgo]) {
            $request = ConsultationRequest::create([
                'practice_area_id' => $areaId,
                'name' => $name,
                'email' => $email,
                'message' => $message,
                'status' => $status,
                'consented_at' => now()->subHours($hoursAgo),
                'is_sample' => true,
            ]);
            $request->forceFill(['created_at' => now()->subHours($hoursAgo), 'updated_at' => now()->subHours($hoursAgo)])->saveQuietly();
        }
    }
}
