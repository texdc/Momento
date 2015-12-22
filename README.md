# Momento

Simple domain event library inspired by [Vaughn Vernon's](https://vaughnvernon.co)
book [Implementing Domain Driven Design](http://www.informit.com/store/implementing-domain-driven-design-9780321834577),
and some of his [code samples](https://github.com/VaughnVernon).

[![Latest Build](https://travis-ci.org/texdc/Momento.png?branch=master)](https://travis-ci.org/texdc/Momento)
[![Dependencies](https://www.versioneye.com/user/projects/52e32811ec137546cb0000de/badge.png)](https://www.versioneye.com/user/projects/52e32811ec137546cb0000de)
[![Latest Stable Version](https://poser.pugx.org/texdc/momento/v/stable.svg)](https://packagist.org/packages/texdc/momento)
[![Total Downloads](https://poser.pugx.org/texdc/momento/downloads.svg)](https://packagist.org/packages/texdc/momento)
[![License](https://poser.pugx.org/texdc/momento/license.svg)](https://packagist.org/packages/texdc/momento)

## Event Handlers
```php
namespace My\Event;

use texdc\momento\AbstractEventHandler;
use texdc\momento\EventInterface;

final class Handler extends AbstractEventHandler
{
    protected static $validEventTypes = [
        FooEvent::TYPE,
        BarEvent::TYPE,
    ];
    
    public function __invoke(EventInterface $anEvent)
    {
        $type = $anEvent->eventType();
        $this->guardValidEventType($type);
        call_user_func([$this, $type], $anEvent);
    }
    
    // ...
}
```
