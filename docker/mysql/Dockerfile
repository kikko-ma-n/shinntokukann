# Dockerイメージを指定
FROM mysql:5.7

# ポートを開ける
EXPOSE 3307

# MYSQL設定ファイルをイメージ内にADD
# ADDはリモートからもファイル追加できる
# ADDは圧縮ファイルが自動解凍される
ADD ./docker/mysql/my.conf /etc/mysql/conf.d/my.conf

# MYSQLの初期設定を行う。
# /docker-entrypoint-initdb.d/ ディレクトリ内に初期化用のスクリプトを置くことで、イメージを起動したときにデータの初期化を行う。
# COPYはリモートからファイルが追加されない。
# COPYは圧縮ファイルが自動解凍されない。
COPY ./docker/mysql/init/* /docker-entrypoint-initdb.d/

# コンテナ起動時に実行するコマンド
CMD ["mysqld"]
