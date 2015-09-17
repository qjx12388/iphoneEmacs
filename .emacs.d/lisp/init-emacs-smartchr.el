;;smartchr config for 自动插入匹配的括号
(add-to-list 'load-path "~/.emacs.d/elpa/emacs-smartchr")
(require 'smartchr)

(defun ik:insert-eol (s)
  (interactive)
  (lexical-let ((s s))
    (smartchr-make-struct
     :insert-fn (lambda ()
		  (save-excursion
		    (goto-char (point-at-eol))
		    (when (not (string= (char-to-string (preceding-char)) s))
		      (insert s))))
     :cleanup-fn (lambda ()
		   (save-excursion
		     (goto-char (point-at-eol))
		     (delete-backward-char (length s)))))))

(defun ik:insert-semicolon-eol ()
  (ik:insert-eol ";"))


(defun smartchr-custom-keybindings ()
  (local-set-key (kbd "=") (smartchr '(" = " " == "  "=")))
  (local-set-key (kbd "(") (smartchr '("(`!!')" "(")))
  (local-set-key (kbd "[") (smartchr '("[`!!']" "[ [`!!'] ]" "[")))
  (local-set-key (kbd "{") (smartchr '("{\n`!!'\n}" "{`!!'}" "{")))
  (local-set-key (kbd "`") (smartchr '("\``!!''" "\`")))
  (local-set-key (kbd "\"") (smartchr '("\"`!!'\"" "\"")))
  (local-set-key (kbd ">") (smartchr '(">" " => " " => '`!!''" " => \"`!!'\"")))
  (local-set-key (kbd "F") (smartchr '("F" "" "$_" "$_->" "@")))
				       (local-set-key (kbd "j") (smartchr '("j" ik:insert-semicolon-eol)))
				       )
				     
(defun smartchr-custom-keybindings-objc ()
  (local-set-key (kbd "@") (smartchr '("@\"`!!'\"" "@")))
)


(add-hook 'c-mode-common-hook 'smartchr-custom-keybindings)

(add-hook 'objc-mode-hook 'smartchr-custom-keybindings-objc)

(provide 'init-emacs-smartchr)
