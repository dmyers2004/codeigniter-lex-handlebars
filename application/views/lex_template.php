{{# Parsed: Hello, World! #}}
Hello, {{ name }}!

{{# Parsed: <h1>Lex is Awesome!</h1> #}}
<h1>{{ title }}</h1>

{{# Parsed: My real name is Lex Luther!</h1> #}}
My real name is {{ real_name.first }} {{ real_name.last }}
<p>{{lex.plugin foo="bar" name="John Doe"}}</p>
<p>{{lex.switch mode="uppercase"}}John Doe{{/lex.switch}}</p>
<p>{{lex.switch mode="lowercase"}}John Doe{{/lex.switch}}</p>