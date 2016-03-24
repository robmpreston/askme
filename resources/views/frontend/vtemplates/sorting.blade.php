<script type="x/template" id="sorting-template">
    <ul class="sorting">
        <li><a href="#" @click="sort('trending')" :class="{active: sortType == 'trending'}">Trending</a></li>
        <li><a href="#" @click="sort('answered')" :class="{active: sortType == 'answered'}">Answered</a></li>
        <li><a href="#" @click="sort('date')" :class="{active: sortType == 'date'}">Date</a></li>
        <li><a href="#" @click="sort('rating')" :class="{active: sortType == 'rating' }">Rating</a></li>
    </ul>
</script>
