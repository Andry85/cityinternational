# IWDTheme
Illicit Webdesign theme to kick start new WordPress websites.

# How to install

Clone repo if needed:

```ssh
git clone git@lab.illicitwebdesign.co.uk:illicitwebdesign-internal/iwdtheme.git
```

Clone submodules:

```ssh
git submodule update --init --recursive
```

cd into theme folder and install dependencies:

```ssh
cd iwdtheme && npm install && typings install
```

Run Grunt:

```ssh
grunt
```

Enable theme in WordPress admin panel.