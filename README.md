TYPO3 Extension hellurl
=======================

This is an unofficial fork of the TYPO3 CMS Extension RealURL
It aims for no backwards compatibility with TYPO3 versions lower than 6.2 thus no messages in the deprecation log.

As the class names changed the configuration needs some slight change, too:

```'userFunc' => 'Nimut\\Hellurl\\UriGeneratorAndResolver->main'```

Other than that, configuration and behaviour (including potential bugs) are the same.

This fork comes with no support. If you find bugs or have questions, you may want to use the original version:
https://github.com/Nimut/TYPO3-hellurl
