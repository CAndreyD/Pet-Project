<form action="{{ route('product.store') }}" method="POST">
    @csrf  <!-- вот этот тег обязательный -->
    
    <label for="name">Название</label>
    <input type="text" name="name" id="name" required>

    <label for="price">Цена</label>
    <input type="number" name="price" id="price" step="0.01" min="0" required>

    <label for="quantity">Количество</label>
    <input type="number" name="quantity" id="quantity" min="0" required>

    <button type="submit">Добавить товар</button>
</form>