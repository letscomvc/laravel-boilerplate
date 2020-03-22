### Log de Atividades ###

A biblioteca Spatie\\ActivityLog é utilizada para gerenciar o log de atividades. Para ela funcionar gravar a atividade relacionada a cada modelo do projeto deve-se adicionar ao model o seguinte:

```php
<?php

// colocar em cada classe
protected static $logFillable = true; // gravar atributos definidos no fillable
protected static $logOnlyDirty = true; // gravar apenas atributos que foram modificados

public function getDescriptionForEvent(string $eventName): string
{
    return 'O #classe em pt-br# foi ' . __('log.event.f.' . $eventName);
    // ou
    return 'A #classe em pt-br# foi ' . __('log.event.m.' . $eventName);
}
```

