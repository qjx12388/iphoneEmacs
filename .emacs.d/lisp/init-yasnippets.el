;; yasnippet
(add-to-list 'load-path "~/.emacs.d/elpa/yasnippet-0.6.1")
(require 'yasnippet)
(setq yas/trigger-key (kbd "C-c <kp-multiply>"))
(yas/initialize)

;; This is where your snippets will lie.
(setq yas/root-directory '("~/.emacs.d/elpa/yasnippet-0.6.1/snippets"))
(mapc 'yas/load-directory yas/root-directory)

(provide 'init-yasnippets)
