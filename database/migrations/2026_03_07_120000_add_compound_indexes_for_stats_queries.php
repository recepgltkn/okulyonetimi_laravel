<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('document_records', function (Blueprint $table) {
            $table->index(['collection_name', 'parent_path'], 'doc_records_collection_parent_idx');
            $table->index(['collection_name', 'parent_path', 'document_id'], 'doc_records_collection_parent_doc_idx');
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->index(['role', 'class_name', 'section'], 'user_profiles_role_class_section_idx');
        });
    }

    public function down(): void
    {
        Schema::table('document_records', function (Blueprint $table) {
            $table->dropIndex('doc_records_collection_parent_idx');
            $table->dropIndex('doc_records_collection_parent_doc_idx');
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropIndex('user_profiles_role_class_section_idx');
        });
    }
};
