Drawing from Largo's 0.7.0 release checklist issue https://github.com/INN/largo/issues/1798, the SCAMP 0.3 tag checklist https://github.com/INN/doubleclick-for-wp/issues/83, https://github.com/INN/republication-tracker-tool/issues/63, and other issues: 


## Team Prep Work

- [ ] check for [upstream updates to `release.sh` in INN/docs](https://github.com/INN/docs/blob/master/projects/wordpress-plugins/release.sh.md) and copy them into this plugin
- [ ] write release announcement
    - [ ] GitHub release drafted
        - can be copied from `changelog.md`
        - [ ] includes encouragement to say hi if you're using the plugin. (This fulfills the "who's using our stuff?" goal in https://github.com/INN/largo/issues/1495)
    - [ ] labs.inn.org blog post written and saved as draft, based on changelog
    - [ ] MailChimp campaign for Largo User mailing list drafted: https://github.com/INN/largo/issues/1796
- [ ] identify non-Github documentation for this plugin
    - [ ] note the location of that documentation
- [ ] update outside documentation for this plugin
    - [ ] https://support.inn.org/article/100-pym-shortcode
    - [ ] any other known doc

## Before merging

The owner of the release needs to complete the following steps **BEFORE** merging the version-bump branch and tagging the release:

- [ ] resolve all secret issues, private issues, or issues with the plugin that are otherwise documented outside of this public repository
- [ ] resolve all GitHub maintainer security advisories: [merge](https://help.github.com/en/articles/collaborating-in-a-temporary-private-fork-to-resolve-a-security-vulnerability) and [publish](https://help.github.com/en/articles/publishing-a-maintainer-security-advisory).
- [ ] update and sort the changelog
    - [ ] make sure changelog has all items from this release, and all PRs and issues are linked
    - [ ] check that ordering and grouping of items is logical.
    - [ ] New features list
    - [ ] Dev-facing updates
    - [ ] Bugfixes
    - [ ] Potentially breaking changes and upgrade notices
    - [ ] Which versions of PHP was this tested against? ([why](https://secure.helpscout.net/conversation/963170317/4444/)) List the PHP versions that we're sure of and that WordPress supports. (See https://github.com/INN/largo/issues/1801)
- [ ] update description
    - [ ] in readme.txt
    - [ ] in plugin description comment
- [ ] bump version number
    - [ ] in readme.txt
    - [ ] in pym-shortcode.php
    - [ ] in readme.md
    - [ ] in docs/maintainer-notes.md
- [ ] testing as described in https://github.com/INN/pym-shortcode/blob/master/docs/maintainer-notes.md

## Release process

- [ ] bump version number
- [ ] tag and push to github
- [ ] [release.sh](https://github.com/INN/docs/blob/master/projects/wordpress-plugins/release.sh.md)
- [ ] publish release in GitHub
- [ ] close milestone

## After release is published

- [ ] update plugins on our sites (inndev? ccs?)
- [ ] publish update announcement blog post
- [ ] tweet announcement and schedule 2-5 for the next 7 days (via TweetDeck, HootSuite, or similar) with simple download prompt or tweets detailing new features, like "Newsroom Staff Pages should be clean and useful. We think so too. See Largo 0.X's new...." Make sure these tweets get cross-tweeted between INN accounts.
- [ ] add to Nerd Alert for following week
- [ ] create the release ticket for the next milestone from this one
- [ ] prune stale and merged branches
- [ ] notify maintainers of related plugins: News Project, WP AMP, Amplify
