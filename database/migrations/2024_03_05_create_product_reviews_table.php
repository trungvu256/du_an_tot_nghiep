use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('set null');
            $table->text('variant_info')->nullable();
            $table->integer('rating');
            $table->text('review')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_reviews');
    }
}
