<script type="x/template" id="sorting-template">
    <ul class="sorting">
        <li><a @click="sort('trending')" :class="{active: sortType == 'trending'}">Trending</a></li>
        <li><a @click="sort('rank')" :class="{active: sortType == 'rank' }">Rank</a></li>
        <li><a @click="sort('answered')" :class="{active: sortType == 'answered'}">Answered</a></li>
        <li><a @click="sort('date')" :class="{active: sortType == 'date'}">Date</a></li>
    </ul>
</script>
