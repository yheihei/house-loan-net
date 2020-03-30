# coding:utf-8
import unittest
import scraping as sc
import os


class ScrapingTest(unittest.TestCase):
  def setUp(self):
    # 初期化処理
    pass

  def tearDown(self):
    # 終了処理
    pass

  def test_get_slug_by_url(self):
    self.assertEqual(sc.getSlugByUrl('https://example.com/aeon.html'), 'aeon')

  def test_get_content_from_target_class_name_on_url(self):
    content = sc.getContents('bankBoxInner', 'https://xn--u9j6nsa9a3643aiuddtuckj386c6f2c.net/aeon.html')
    # print content
    self.assertEqual(
      True,
      len(content) != 0
    )
  
  def test_read_csv_to_list(self):
    # CSVを読み込んで列ごとにデータを格納する
    rows = sc.readOriginalContentsCSV(os.getcwd()+'/target_urls.csv')
    self.assertEqual(
      True,
      len(rows) != 0
    )
    # print rows
  
  def test_get_headers_colums_name_to_number(self):
    # ヘッダの名前と列数の対応表を作ることができる
    rows = [['URL','Title','Description','Keyword','H1']]
    headNameToIndexs = sc.getHeaderToIndexes(rows)
    expected = {
      'URL':0,
      'Title':1,
      'Description':2,
      'Keyword':3,
      'H1':4
    }
    self.assertEqual(expected, headNameToIndexs)
  
  # def test_get_title_from_csv_data(self):
  #   # CSVデータからタイトルを抜き出す
  #   rows = sc.readOriginalContentsCSV(os.getcwd()+'/target_urls.csv')
  #   # headNameToIndexs = sc.getHeaderToIndexes(rows)
  #   expected = "イオン銀行の住宅ローン金利と考察,イオン銀行では金利差引幅でどのくらい優遇されるかなどが異なる２種類の住宅ローンが存在します。またイオン銀行ならではの「イオンセレクトクラブ」も魅力。"
  #   self.assertEqual(expected, sc.getTitleFromCSVData(rows[1]), headNameToIndexs)

  def test_create_import_csv_file(self):
    rows = sc.readOriginalContentsCSV(os.getcwd()+'/target_urls.csv')
    headNameToIndexs = sc.getHeaderToIndexes(rows)
    import_csv_rows = sc.createImportFileDataByCSVData(rows, headNameToIndexs)
    for import_csv_row in import_csv_rows:
      self.assertEqual(
        "aeon",
        import_csv_row['Slug']
      )
      self.assertEqual(
        True,
        len(import_csv_row['Content']) != 0
      )
      break; # 1行目だけ検査してやめる
    sc.createFileByData('import_wp_data.csv', import_csv_rows)


if __name__ == "__main__":
  unittest.main()