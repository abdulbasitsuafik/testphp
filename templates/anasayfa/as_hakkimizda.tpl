{% extends 'base.tpl' %}

{% block main %}

<link href="{{THEME_PATH}}assets/css/hakkimizda.css" rel="stylesheet">

{% set headlinesoku = islem.sqlSorgu("SELECT * FROM "~prefix~"headlines a JOIN "~prefix~"headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id order by a.rank ASC limit 1",{":lang":sessions.dil,":head_id":"10"}) %}
<h1>{{headlinesoku[0].headlines}}</h1>
<h2>{{headlinesoku[0].ek}}</h2>
<h3>{{islem.kisalt(headlinesoku[0].content,150)}}</h3>
                        
{% endblock %}