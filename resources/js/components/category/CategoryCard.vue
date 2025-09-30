<template>
    <div class="category-card">
        <div class="category-header">
            <h3>{{ category.name }}</h3>
            <div class="actions">
                <button @click="$emit('edit-category', category)" class="btn-icon">✏️</button>
                <button @click="$emit('delete-category', category.id)" class="btn-icon danger">🗑️</button>
            </div>
        </div>
        <p v-if="category.description">{{ category.description }}</p>

        <!-- Товары -->
        <div>Товары:
            <ul v-if="category.products.length">
                <li v-for="p in category.products" :key="p.id">{{ p.name }} — {{ p.price }}₽</li>
            </ul>
        </div>
        <!-- Вложенные категории -->
        <div v-if="category.children.length" class="children">Категории:
            <CategoryCard v-for="child in category.children" :key="child.id" :category="child"
                @edit-category="$emit('edit-category', $event)" @delete-category="$emit('delete-category', $event)" />
        </div>
    </div>
</template>

<script setup>
defineProps({ category: Object })
</script>

<style scoped>
.category-card {
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 10px;
    margin-bottom: 10px;
}

.category-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.children {
    margin-left: 16px;
    margin-top: 8px;
}

.btn-icon {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
    margin-left: 4px;
}

.btn-icon.danger:hover {
    color: red;
}
</style>
